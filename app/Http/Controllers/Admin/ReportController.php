<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PemeriksaanMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        // Statistik ringkasan
        $totalPemeriksaan = PemeriksaanMaster::count();
        $pemeriksaanBulanIni = PemeriksaanMaster::whereMonth('tanggal_pemeriksaan', date('m'))
            ->whereYear('tanggal_pemeriksaan', date('Y'))
            ->count();
        $totalPasien = \App\Models\User::where('role', 'pasien')->count();

        // Rata-rata per bulan
        $totalSetahun = PemeriksaanMaster::whereYear('tanggal_pemeriksaan', date('Y'))->count();
        $rataPerBulan = round($totalSetahun / 12, 1);

        // Data chart
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = PemeriksaanMaster::whereMonth('tanggal_pemeriksaan', $i)
                ->whereYear('tanggal_pemeriksaan', date('Y'))
                ->count();
        }

        // Pemeriksaan terbaru
        $latestPemeriksaan = PemeriksaanMaster::with('user')
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->limit(10)
            ->get();

        return view('admin.reports.index', compact(
            'totalPemeriksaan',
            'pemeriksaanBulanIni',
            'totalPasien',
            'rataPerBulan',
            'chartData',
            'latestPemeriksaan'
        ));
    }

    public function harian(Request $request)
    {
        $date = $request->get('date', date('Y-m-d'));

        $reports = PemeriksaanMaster::with('user')
            ->whereDate('tanggal_pemeriksaan', $date)
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->get();

        return view('admin.reports.harian', compact('reports', 'date'));
    }

    public function bulanan(Request $request)
    {
        // Pastikan tipe data integer
        $month = (int) $request->get('month', date('m'));
        $year = (int) $request->get('year', date('Y'));

        // Validasi range
        $month = max(1, min(12, $month));
        $year = max(2000, min(2099, $year));

        $reports = PemeriksaanMaster::with('user')
            ->whereMonth('tanggal_pemeriksaan', $month)
            ->whereYear('tanggal_pemeriksaan', $year)
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->get();

        // Data untuk grafik harian
        $dailyData = [];
        $daysInMonth = Carbon::create($year, $month)->daysInMonth;
        $tertinggiPerHari = 0;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($year, $month, $day)->format('Y-m-d');
            $jumlah = PemeriksaanMaster::whereDate('tanggal_pemeriksaan', $date)->count();
            $dailyData[] = ['tanggal' => $day, 'jumlah' => $jumlah];
            if ($jumlah > $tertinggiPerHari) $tertinggiPerHari = $jumlah;
        }

        return view('admin.reports.bulanan', compact('reports', 'month', 'year', 'dailyData', 'tertinggiPerHari'));
    }

    public function tahunan(Request $request)
    {
        $year = (int) $request->get('year', date('Y'));
        $year = max(2000, min(2099, $year));

        $reports = PemeriksaanMaster::with('user')
            ->whereYear('tanggal_pemeriksaan', $year)
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->get();

        // Data per bulan
        $monthlyData = PemeriksaanMaster::select(
            DB::raw('MONTH(tanggal_pemeriksaan) as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('tanggal_pemeriksaan', $year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $monthlyTotals = array_fill(0, 12, 0);
        foreach ($monthlyData as $data) {
            $monthlyTotals[$data->bulan - 1] = $data->total;
        }

        // Bulan tersibuk
        $bulanTersibuk = '';
        $jumlahTersibuk = 0;
        $bulanNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        foreach ($monthlyTotals as $index => $total) {
            if ($total > $jumlahTersibuk) {
                $jumlahTersibuk = $total;
                $bulanTersibuk = $bulanNames[$index];
            }
        }

        // Data tahun lalu untuk perbandingan
        $lastYearData = PemeriksaanMaster::select(
            DB::raw('MONTH(tanggal_pemeriksaan) as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('tanggal_pemeriksaan', $year - 1)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->pluck('total', 'bulan')
            ->toArray();

        // Persentase pertumbuhan
        $totalLastYear = PemeriksaanMaster::whereYear('tanggal_pemeriksaan', $year - 1)->count();
        $persentasePertumbuhan = $totalLastYear > 0
            ? round((($reports->count() - $totalLastYear) / $totalLastYear) * 100, 1)
            : ($reports->count() > 0 ? 100 : 0);

        return view('admin.reports.tahunan', compact(
            'reports',
            'year',
            'monthlyTotals',
            'bulanTersibuk',
            'jumlahTersibuk',
            'lastYearData',
            'persentasePertumbuhan',
            'monthlyData'
        ));
    }
}
