<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\PemeriksaanMaster;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class HasilController extends Controller
{
    public function index()
    {
        $hasil = PemeriksaanMaster::with(['petugas', 'dokter'])
            ->where('user_id', Auth::id())
            ->where('status_validasi', 'divalidasi')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pasien.hasil.index', compact('hasil'));
    }

    public function show($id)
    {
        $pemeriksaan = PemeriksaanMaster::with(['user', 'petugas', 'dokter', 'hasilPemeriksaan.parameter'])
            ->where('user_id', Auth::id())
            ->where('status_validasi', 'divalidasi')
            ->findOrFail($id);

        return view('pasien.hasil.show', compact('pemeriksaan'));
    }

    public function downloadPdf($id)
    {
        $pemeriksaan = PemeriksaanMaster::with(['user', 'petugas', 'dokter', 'hasilPemeriksaan.parameter'])
            ->where('user_id', Auth::id())
            ->where('status_validasi', 'divalidasi')
            ->findOrFail($id);

        $appName = Setting::get('app_name', 'Laboratorium Kesehatan');
        $logo = Setting::get('app_logo');

        $data = [
            'pemeriksaan' => $pemeriksaan,
            'appName' => $appName,
            'logo' => $logo,
            'tanggal_cetak' => now()->format('d/m/Y H:i:s')
        ];

        $pdf = Pdf::loadView('pasien.hasil.pdf', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('hasil_pemeriksaan_' . $pemeriksaan->id . '.pdf');
    }
}
