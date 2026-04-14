<?php

namespace App\Http\Controllers\PetugasLab;

use App\Http\Controllers\Controller;
use App\Models\PemeriksaanMaster;
use App\Models\ParameterLab;
use App\Models\HasilPemeriksaanLab;
use App\Models\User;
use App\Models\LogAktivitas;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;

class HasilLabController extends Controller
{
    public function edit($id)
    {
        $pemeriksaan = PemeriksaanMaster::with(['user', 'hasilPemeriksaan'])->findOrFail($id);
        $parameters = ParameterLab::where('is_active', true)->orderBy('kategori')->orderBy('nama_param')->get();

        return view('petugaslab.hasil-lab.edit', compact('pemeriksaan', 'parameters'));
    }

    public function update(Request $request, $id)
    {
        $pemeriksaan = PemeriksaanMaster::with(['user'])->findOrFail($id);

        if ($request->has('hasil')) {
            foreach ($request->hasil as $parameter_id => $nilai) {
                $hasil = HasilPemeriksaanLab::where('pemeriksaan_id', $pemeriksaan->id)
                    ->where('parameter_id', $parameter_id)
                    ->first();

                if ($hasil) {
                    $hasil->update(['nilai' => $nilai]);
                } elseif (!empty($nilai)) {
                    HasilPemeriksaanLab::create([
                        'pemeriksaan_id' => $pemeriksaan->id,
                        'parameter_id' => $parameter_id,
                        'nilai' => $nilai,
                    ]);
                }
            }
        }

        LogAktivitas::create([
            'user_id' => auth()->user()->id,
            'aktivitas' => "Mengupdate hasil lab pemeriksaan ID: {$id}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'waktu' => now(),
        ]);

        // ========== NOTIFIKASI ==========

        // 1. Notifikasi untuk pasien
        NotificationHelper::send(
            $pemeriksaan->user_id,
            'Hasil Laboratorium Telah Diinput',
            'Hasil pemeriksaan laboratorium Anda telah diinput. Menunggu validasi dari dokter.',
            'info',
            route('pasien.riwayat.show', $pemeriksaan->id)
        );

        // 2. Notifikasi untuk dokter
        $dokters = User::where('role', 'dokter')->where('is_active', true)->get();
        foreach ($dokters as $dokter) {
            NotificationHelper::send(
                $dokter->id,
                'Hasil Lab Siap Divalidasi',
                "Hasil lab untuk pasien {$pemeriksaan->user->nama_lengkap} sudah diinput dan siap divalidasi.",
                'warning',
                route('dokter.validasi.index')
            );
        }

        return redirect()->route('petugas_lab.pemeriksaan.index')
            ->with('success', 'Hasil laboratorium berhasil diupdate');
    }
}
