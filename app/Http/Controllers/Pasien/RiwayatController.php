<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\PemeriksaanMaster;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $riwayat = PemeriksaanMaster::with(['petugas', 'dokter'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pasien.riwayat.index', compact('riwayat'));
    }

    public function show($id)
    {
        $pemeriksaan = PemeriksaanMaster::with(['user', 'petugas', 'dokter', 'hasilPemeriksaan.parameter'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('pasien.riwayat.show', compact('pemeriksaan'));
    }
}
