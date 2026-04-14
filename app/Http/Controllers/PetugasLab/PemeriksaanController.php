<?php

namespace App\Http\Controllers\PetugasLab;

use App\Http\Controllers\Controller;
use App\Models\PemeriksaanMaster;
use App\Models\User;
use App\Models\ParameterLab;
use App\Models\HasilPemeriksaanLab;
use App\Models\LogAktivitas;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;

class PemeriksaanController extends Controller
{
    public function index()
    {
        $pemeriksaans = PemeriksaanMaster::with(['user', 'petugas'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('petugaslab.pemeriksaan.index', compact('pemeriksaans'));
    }

    public function create()
    {
        $pasien = User::where('role', 'pasien')
            ->where('is_active', true)
            ->orderBy('nama_lengkap')
            ->get();

        $parameters = ParameterLab::where('is_active', true)
            ->orderBy('kategori')
            ->orderBy('nama_param')
            ->get();

        return view('petugaslab.pemeriksaan.create', compact('pasien', 'parameters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tinggi_cm' => 'nullable|numeric',
            'berat_kg' => 'nullable|numeric',
            'lingkar_perut_cm' => 'nullable|numeric',
            'sistolik' => 'nullable|integer',
            'diastolik' => 'nullable|integer',
        ]);

        $pemeriksaan = PemeriksaanMaster::create([
            'user_id' => $request->user_id,
            'petugas_id' => auth()->user()->id,
            'tanggal_pemeriksaan' => now(),
            'tinggi_cm' => $request->tinggi_cm,
            'berat_kg' => $request->berat_kg,
            'lingkar_perut_cm' => $request->lingkar_perut_cm,
            'sistolik' => $request->sistolik,
            'diastolik' => $request->diastolik,
            'status_validasi' => 'draft',
        ]);

        if ($request->has('hasil')) {
            foreach ($request->hasil as $parameter_id => $nilai) {
                if (!empty($nilai)) {
                    HasilPemeriksaanLab::create([
                        'pemeriksaan_id' => $pemeriksaan->id,
                        'parameter_id' => $parameter_id,
                        'nilai' => $nilai,
                    ]);
                }
            }
        }

        // Log aktivitas
        LogAktivitas::create([
            'user_id' => auth()->user()->id,
            'aktivitas' => "Menambah pemeriksaan baru untuk pasien ID: {$request->user_id}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'waktu' => now(),
        ]);

        // ========== NOTIFIKASI ==========

        // 1. Notifikasi untuk pasien
        $pasien = User::find($request->user_id);
        NotificationHelper::send(
            $request->user_id,
            'Pemeriksaan Baru',
            'Pemeriksaan Anda telah dilakukan. Silakan tunggu validasi dari dokter.',
            'info',
            route('pasien.riwayat.show', $pemeriksaan->id)
        );

        // 2. Notifikasi untuk semua dokter
        $dokters = User::where('role', 'dokter')->where('is_active', true)->get();
        foreach ($dokters as $dokter) {
            NotificationHelper::send(
                $dokter->id,
                'Pemeriksaan Menunggu Validasi',
                "Pemeriksaan untuk pasien {$pasien->nama_lengkap} menunggu validasi.",
                'warning',
                route('dokter.validasi.index')
            );
        }

        // 3. Notifikasi untuk admin
        $admins = User::where('role', 'admin')->where('is_active', true)->get();
        foreach ($admins as $admin) {
            NotificationHelper::send(
                $admin->id,
                'Pemeriksaan Baru',
                "Pemeriksaan baru untuk pasien {$pasien->nama_lengkap} telah ditambahkan oleh " . auth()->user()->nama_lengkap,
                'info',
                route('admin.reports.index')
            );
        }

        return redirect()->route('petugas_lab.pemeriksaan.index')
            ->with('success', 'Pemeriksaan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pemeriksaan = PemeriksaanMaster::with(['user', 'hasilPemeriksaan'])->findOrFail($id);
        $parameters = ParameterLab::where('is_active', true)->orderBy('kategori')->orderBy('nama_param')->get();

        return view('petugaslab.pemeriksaan.edit', compact('pemeriksaan', 'parameters'));
    }

    public function update(Request $request, $id)
    {
        $pemeriksaan = PemeriksaanMaster::findOrFail($id);

        $request->validate([
            'tinggi_cm' => 'nullable|numeric',
            'berat_kg' => 'nullable|numeric',
            'lingkar_perut_cm' => 'nullable|numeric',
            'sistolik' => 'nullable|integer',
            'diastolik' => 'nullable|integer',
        ]);

        $pemeriksaan->update([
            'tinggi_cm' => $request->tinggi_cm,
            'berat_kg' => $request->berat_kg,
            'lingkar_perut_cm' => $request->lingkar_perut_cm,
            'sistolik' => $request->sistolik,
            'diastolik' => $request->diastolik,
        ]);

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
            'aktivitas' => "Mengupdate pemeriksaan ID: {$id}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'waktu' => now(),
        ]);

        // ========== NOTIFIKASI ==========

        NotificationHelper::send(
            $pemeriksaan->user_id,
            'Data Pemeriksaan Diperbarui',
            'Data pemeriksaan Anda telah diperbarui oleh petugas lab.',
            'info',
            route('pasien.riwayat.show', $pemeriksaan->id)
        );

        return redirect()->route('petugas_lab.pemeriksaan.index')
            ->with('success', 'Pemeriksaan berhasil diupdate');
    }

    public function destroy(Request $request, $id)
    {
        $pemeriksaan = PemeriksaanMaster::findOrFail($id);
        $userId = $pemeriksaan->user_id;
        $pemeriksaan->delete();

        LogAktivitas::create([
            'user_id' => auth()->user()->id,
            'aktivitas' => "Menghapus pemeriksaan ID: {$id}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'waktu' => now(),
        ]);

        // ========== NOTIFIKASI ==========

        NotificationHelper::send(
            $userId,
            'Pemeriksaan Dihapus',
            'Pemeriksaan Anda telah dihapus oleh petugas lab. Silakan hubungi petugas jika ada pertanyaan.',
            'danger',
            route('pasien.dashboard')
        );

        return redirect()->route('petugas_lab.pemeriksaan.index')
            ->with('success', 'Pemeriksaan berhasil dihapus');
    }
}
