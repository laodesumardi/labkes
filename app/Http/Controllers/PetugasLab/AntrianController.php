<?php

namespace App\Http\Controllers\PetugasLab;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\User;
use App\Models\LogAktivitas;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
    public function index()
    {
        $antrian = Antrian::with('user')
            ->whereDate('waktu_masuk', today())
            ->orderByRaw("FIELD(status, 'menunggu', 'proses', 'selesai')")
            ->orderBy('created_at', 'asc')
            ->get();

        $totalMenunggu = Antrian::where('status', 'menunggu')->whereDate('waktu_masuk', today())->count();
        $totalProses = Antrian::where('status', 'proses')->whereDate('waktu_masuk', today())->count();
        $totalSelesai = Antrian::where('status', 'selesai')->whereDate('waktu_masuk', today())->count();

        $pasien = User::where('role', 'pasien')->where('is_active', true)->orderBy('nama_lengkap')->get();

        return view('petugaslab.antrian.index', compact('antrian', 'totalMenunggu', 'totalProses', 'totalSelesai', 'pasien'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jenis_pemeriksaan' => 'required|in:darah,urin,lengkap',
        ]);

        $today = date('Ymd');
        $lastAntrian = Antrian::whereDate('waktu_masuk', today())->orderBy('id', 'desc')->first();

        if ($lastAntrian) {
            $lastNumber = intval(substr($lastAntrian->nomor_antrian, -3));
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        $nomorAntrian = "ANT-{$today}-{$newNumber}";

        $antrian = Antrian::create([
            'user_id' => $request->user_id,
            'nomor_antrian' => $nomorAntrian,
            'jenis_pemeriksaan' => $request->jenis_pemeriksaan,
            'status' => 'menunggu',
            'waktu_masuk' => now(),
        ]);

        LogAktivitas::create([
            'user_id' => auth()->user()->id,
            'aktivitas' => "Menambah antrian baru: {$nomorAntrian}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'waktu' => now(),
        ]);

        // ========== NOTIFIKASI ==========

        NotificationHelper::send(
            $request->user_id,
            'Antrian Baru',
            "Anda mendapatkan nomor antrian {$nomorAntrian} untuk pemeriksaan " . ucfirst($request->jenis_pemeriksaan),
            'info',
            route('pasien.dashboard')
        );

        return redirect()->route('petugas_lab.antrian.index')
            ->with('success', "Antrian {$nomorAntrian} berhasil ditambahkan");
    }

    public function proses(Request $request, $id)
    {
        $antrian = Antrian::findOrFail($id);
        $antrian->status = 'proses';
        $antrian->waktu_proses = now();
        $antrian->save();

        // ========== NOTIFIKASI ==========

        NotificationHelper::send(
            $antrian->user_id,
            'Antrian Diproses',
            "Antrian Anda dengan nomor {$antrian->nomor_antrian} sedang diproses.",
            'warning',
            route('pasien.dashboard')
        );

        return redirect()->route('petugas_lab.antrian.index')
            ->with('success', "Antrian {$antrian->nomor_antrian} sedang diproses");
    }

    public function selesai(Request $request, $id)
    {
        $antrian = Antrian::findOrFail($id);
        $antrian->status = 'selesai';
        $antrian->waktu_selesai = now();
        $antrian->save();

        // ========== NOTIFIKASI ==========

        NotificationHelper::send(
            $antrian->user_id,
            'Antrian Selesai',
            "Antrian Anda dengan nomor {$antrian->nomor_antrian} telah selesai. Silakan menuju loket pemeriksaan.",
            'success',
            route('pasien.dashboard')
        );

        return redirect()->route('petugas_lab.antrian.index')
            ->with('success', "Antrian {$antrian->nomor_antrian} selesai");
    }
}
