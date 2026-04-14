<?php

namespace App\Http\Controllers\PetugasLab;

use App\Http\Controllers\Controller;
use App\Models\PemeriksaanMaster;
use App\Models\Antrian;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik
        $totalPemeriksaan = PemeriksaanMaster::count();
        $pemeriksaanHariIni = PemeriksaanMaster::whereDate('tanggal_pemeriksaan', today())->count();
        $pemeriksaanMenunggu = PemeriksaanMaster::where('status_validasi', 'draft')->count();
        $pemeriksaanDivalidasi = PemeriksaanMaster::where('status_validasi', 'divalidasi')->count();

        // Antrian
        $antrianMenunggu = Antrian::where('status', 'menunggu')->whereDate('waktu_masuk', today())->count();
        $antrianProses = Antrian::where('status', 'proses')->whereDate('waktu_masuk', today())->count();
        $antrianSelesai = Antrian::where('status', 'selesai')->whereDate('waktu_masuk', today())->count();

        // Pemeriksaan terbaru
        $latestPemeriksaan = PemeriksaanMaster::with(['user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Antrian hari ini
        $antrianHariIni = Antrian::with(['user'])
            ->whereDate('waktu_masuk', today())
            ->orderBy('created_at', 'asc')
            ->limit(10)
            ->get();

        // Data untuk chart (7 hari terakhir)
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartData[] = [
                'tanggal' => $date->format('d/m'),
                'jumlah' => PemeriksaanMaster::whereDate('tanggal_pemeriksaan', $date)->count()
            ];
        }

        return view('petugaslab.dashboard', compact(
            'totalPemeriksaan',
            'pemeriksaanHariIni',
            'pemeriksaanMenunggu',
            'pemeriksaanDivalidasi',
            'antrianMenunggu',
            'antrianProses',
            'antrianSelesai',
            'latestPemeriksaan',
            'antrianHariIni',
            'chartData'
        ));
    }
}
