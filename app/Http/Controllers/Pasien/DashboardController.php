<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\PemeriksaanMaster;
use App\Models\Antrian;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistik
        $totalPemeriksaan = PemeriksaanMaster::where('user_id', $user->id)->count();
        $pemeriksaanDivalidasi = PemeriksaanMaster::where('user_id', $user->id)
            ->where('status_validasi', 'divalidasi')
            ->count();
        $pemeriksaanMenunggu = PemeriksaanMaster::where('user_id', $user->id)
            ->where('status_validasi', 'draft')
            ->count();
        $pemeriksaanDibatalkan = PemeriksaanMaster::where('user_id', $user->id)
            ->where('status_validasi', 'dibatalkan')
            ->count();

        // Pemeriksaan terbaru
        $pemeriksaanTerbaru = PemeriksaanMaster::with(['petugas', 'dokter'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Hasil terbaru yang sudah divalidasi
        $hasilTerbaru = PemeriksaanMaster::with(['dokter'])
            ->where('user_id', $user->id)
            ->where('status_validasi', 'divalidasi')
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        // Antrian aktif
        $antrianAktif = Antrian::where('user_id', $user->id)
            ->whereIn('status', ['menunggu', 'proses'])
            ->whereDate('waktu_masuk', today())
            ->first();

        // Data untuk chart (6 bulan terakhir)
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = now()->subMonths($i);
            $jumlah = PemeriksaanMaster::where('user_id', $user->id)
                ->whereYear('tanggal_pemeriksaan', $bulan->year)
                ->whereMonth('tanggal_pemeriksaan', $bulan->month)
                ->count();
            $chartData[] = [
                'bulan' => $bulan->format('M Y'),
                'jumlah' => $jumlah
            ];
        }

        return view('pasien.dashboard', compact(
            'totalPemeriksaan',
            'pemeriksaanDivalidasi',
            'pemeriksaanMenunggu',
            'pemeriksaanDibatalkan',
            'pemeriksaanTerbaru',
            'hasilTerbaru',
            'antrianAktif',
            'chartData'
        ));
    }
}
