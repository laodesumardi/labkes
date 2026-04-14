<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\PemeriksaanMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPemeriksaan = PemeriksaanMaster::count();
        $menungguValidasi = PemeriksaanMaster::where('status_validasi', 'draft')->count();
        $sudahDivalidasi = PemeriksaanMaster::where('status_validasi', 'divalidasi')->count();

        $latestPemeriksaan = PemeriksaanMaster::with(['user', 'petugas'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $statPerBulan = PemeriksaanMaster::select(
            DB::raw('DATE_FORMAT(tanggal_pemeriksaan, "%Y-%m") as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('bulan')
            ->orderBy('bulan', 'desc')
            ->limit(6)
            ->get();

        return view('dokter.dashboard', compact(
            'totalPemeriksaan',
            'menungguValidasi',
            'sudahDivalidasi',
            'latestPemeriksaan',
            'statPerBulan'
        ));
    }
}
