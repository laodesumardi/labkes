<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\PemeriksaanMaster;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    public function index()
    {
        $rekamMedis = PemeriksaanMaster::with(['user', 'petugas', 'dokter'])
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->paginate(15);

        return view('dokter.rekam-medis.index', compact('rekamMedis'));
    }

    public function show($id)
    {
        $rekamMedis = PemeriksaanMaster::with(['user', 'petugas', 'dokter', 'hasilPemeriksaan.parameter'])
            ->findOrFail($id);

        return view('dokter.rekam-medis.show', compact('rekamMedis'));
    }
}
