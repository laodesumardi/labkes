<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\PemeriksaanMaster;
use App\Models\User;
use App\Models\LogAktivitas;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;

class ValidasiController extends Controller
{
    public function index()
    {
        $menungguValidasi = PemeriksaanMaster::with(['user', 'petugas'])
            ->where('status_validasi', 'draft')
            ->orderBy('created_at', 'asc')
            ->paginate(15);

        return view('dokter.validasi.index', compact('menungguValidasi'));
    }

    public function validate(Request $request, $id)
    {
        $pemeriksaan = PemeriksaanMaster::with(['user', 'petugas'])->findOrFail($id);
        $pemeriksaan->status_validasi = 'divalidasi';
        $pemeriksaan->dokter_id = auth()->id();

        if ($request->has('catatan')) {
            $pemeriksaan->catatan = $request->catatan;
        }

        $pemeriksaan->save();

        LogAktivitas::create([
            'user_id' => auth()->user()->id,
            'aktivitas' => "Memvalidasi pemeriksaan pasien: {$pemeriksaan->user->nama_lengkap}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'waktu' => now(),
        ]);

        // ========== NOTIFIKASI ==========

        // 1. Notifikasi untuk pasien
        NotificationHelper::send(
            $pemeriksaan->user_id,
            'Hasil Pemeriksaan Telah Divalidasi',
            'Hasil pemeriksaan Anda telah divalidasi oleh dokter. Silakan lihat hasilnya.',
            'success',
            route('pasien.hasil.show', $pemeriksaan->id)
        );

        // 2. Notifikasi untuk petugas lab
        NotificationHelper::send(
            $pemeriksaan->petugas_id,
            'Pemeriksaan Telah Divalidasi',
            "Pemeriksaan untuk pasien {$pemeriksaan->user->nama_lengkap} telah divalidasi oleh Dr. " . auth()->user()->nama_lengkap,
            'success',
            route('petugas_lab.pemeriksaan.index')
        );

        // 3. Notifikasi untuk admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            NotificationHelper::send(
                $admin->id,
                'Pemeriksaan Divalidasi',
                "Pemeriksaan untuk pasien {$pemeriksaan->user->nama_lengkap} telah divalidasi oleh Dr. " . auth()->user()->nama_lengkap,
                'info',
                route('admin.reports.index')
            );
        }

        return redirect()->route('dokter.validasi.index')
            ->with('success', 'Pemeriksaan berhasil divalidasi');
    }

    public function cancel(Request $request, $id)
    {
        $pemeriksaan = PemeriksaanMaster::with(['user', 'petugas'])->findOrFail($id);
        $pemeriksaan->status_validasi = 'dibatalkan';
        $pemeriksaan->save();

        LogAktivitas::create([
            'user_id' => auth()->user()->id,
            'aktivitas' => "Membatalkan validasi pemeriksaan pasien: {$pemeriksaan->user->nama_lengkap}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'waktu' => now(),
        ]);

        // ========== NOTIFIKASI ==========

        // 1. Notifikasi untuk pasien
        NotificationHelper::send(
            $pemeriksaan->user_id,
            'Validasi Pemeriksaan Dibatalkan',
            'Validasi pemeriksaan Anda dibatalkan. Silakan hubungi petugas lab untuk informasi lebih lanjut.',
            'danger',
            route('pasien.riwayat.show', $pemeriksaan->id)
        );

        // 2. Notifikasi untuk petugas lab
        NotificationHelper::send(
            $pemeriksaan->petugas_id,
            'Validasi Pemeriksaan Dibatalkan',
            "Validasi pemeriksaan untuk pasien {$pemeriksaan->user->nama_lengkap} dibatalkan oleh dokter.",
            'warning',
            route('petugas_lab.pemeriksaan.edit', $pemeriksaan->id)
        );

        return redirect()->route('dokter.validasi.index')
            ->with('success', 'Validasi pemeriksaan dibatalkan');
    }
}
