<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\PemeriksaanMaster;
use Illuminate\Http\Request;
use App\Helpers\NotificationHelper;

class PemeriksaanController extends Controller
{
    public function index()
    {
        $pemeriksaans = PemeriksaanMaster::with(['user', 'petugas'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('dokter.pemeriksaan.index', compact('pemeriksaans'));
    }

    public function show($id)
    {
        $pemeriksaan = PemeriksaanMaster::with(['user', 'petugas', 'hasilPemeriksaan.parameter'])
            ->findOrFail($id);

        return view('dokter.pemeriksaan.show', compact('pemeriksaan'));
    }

    public function edit($id)
    {
        $pemeriksaan = PemeriksaanMaster::with(['user', 'petugas', 'hasilPemeriksaan.parameter'])
            ->findOrFail($id);

        return view('dokter.pemeriksaan.edit', compact('pemeriksaan'));
    }

    public function update(Request $request, $id)
    {
        $pemeriksaan = PemeriksaanMaster::findOrFail($id);

        $validated = $request->validate([
            'catatan' => 'nullable|string',
            'status_validasi' => 'required|in:draft,divalidasi,dibatalkan',
        ]);

        $pemeriksaan->update($validated);

        return redirect()->route('dokter.pemeriksaan.index')
            ->with('success', 'Data pemeriksaan berhasil diperbarui');
    }
}
