<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PemeriksaanMaster;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalPasien = User::where('role', 'pasien')->count();
        $totalDokter = User::where('role', 'dokter')->count();
        $totalPetugasLab = User::where('role', 'petugas_lab')->count();

        $totalPemeriksaan = PemeriksaanMaster::count();
        $totalPemeriksaanBulanIni = PemeriksaanMaster::whereMonth('tanggal_pemeriksaan', now()->month)->count();
        $totalPemeriksaanMenunggu = PemeriksaanMaster::where('status_validasi', 'draft')->count();

        // Chart: Pemeriksaan per bulan
        $pemeriksaanPerBulan = PemeriksaanMaster::select(
            DB::raw('MONTH(tanggal_pemeriksaan) as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('tanggal_pemeriksaan', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $chartData = array_fill(0, 12, 0);
        foreach ($pemeriksaanPerBulan as $data) {
            $chartData[$data->bulan - 1] = $data->total;
        }

        // Recent activities
        $recentActivities = LogAktivitas::with('user')
            ->orderBy('waktu', 'desc')
            ->limit(10)
            ->get();

        // Top pasien
        $topPasien = PemeriksaanMaster::select('user_id', DB::raw('COUNT(*) as total'))
            ->with('user')
            ->groupBy('user_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalPasien',
            'totalDokter',
            'totalPetugasLab',
            'totalPemeriksaan',
            'totalPemeriksaanBulanIni',
            'totalPemeriksaanMenunggu',
            'bulanLabels',
            'chartData',
            'recentActivities',
            'topPasien'
        ));
    }
}
