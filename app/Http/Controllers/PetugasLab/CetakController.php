<?php

namespace App\Http\Controllers\PetugasLab;

use App\Http\Controllers\Controller;
use App\Models\PemeriksaanMaster;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class CetakController extends Controller
{
    public function index()
    {
        $pemeriksaans = PemeriksaanMaster::with(['user', 'dokter'])
            ->where('status_validasi', 'divalidasi')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('petugaslab.cetak.index', compact('pemeriksaans'));
    }

    public function show($id)
    {
        $pemeriksaan = PemeriksaanMaster::with(['user', 'petugas', 'dokter', 'hasilPemeriksaan.parameter'])
            ->findOrFail($id);

        return view('petugaslab.cetak.show', compact('pemeriksaan'));
    }
}
