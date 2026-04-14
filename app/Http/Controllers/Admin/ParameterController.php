<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParameterLab;
use App\Models\User;
use App\Models\LogAktivitas;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    public function index()
    {
        $parameters = ParameterLab::orderBy('kategori')->orderBy('nama_param')->paginate(20);
        return view('admin.parameters.index', compact('parameters'));
    }

    public function create()
    {
        return view('admin.parameters.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_param' => 'required|unique:parameter_lab',
            'nama_param' => 'required',
            'satuan' => 'nullable',
            'nilai_normal_min' => 'nullable|numeric',
            'nilai_normal_max' => 'nullable|numeric',
            'kategori' => 'required|in:kimia_darah,urin,serologi,narkoba,lainnya',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $parameter = ParameterLab::create($validated);

        LogAktivitas::create([
            'user_id' => auth()->user()->id,
            'aktivitas' => "Menambah parameter lab: {$parameter->nama_param} ({$parameter->kode_param})",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'waktu' => now(),
        ]);

        // ========== NOTIFIKASI ==========

        // 1. Notifikasi untuk semua petugas lab
        $petugasLabs = User::where('role', 'petugas_lab')->where('is_active', true)->get();
        foreach ($petugasLabs as $petugas) {
            NotificationHelper::send(
                $petugas->id,
                'Parameter Lab Baru',
                "Parameter lab baru '{$parameter->nama_param}' telah ditambahkan.",
                'info',
                route('petugas_lab.pemeriksaan.create')
            );
        }

        // 2. Notifikasi untuk semua dokter
        $dokters = User::where('role', 'dokter')->where('is_active', true)->get();
        foreach ($dokters as $dokter) {
            NotificationHelper::send(
                $dokter->id,
                'Parameter Lab Baru',
                "Parameter lab baru '{$parameter->nama_param}' telah ditambahkan.",
                'info',
                route('dokter.pemeriksaan.index')
            );
        }

        return redirect()->route('admin.parameters.index')
            ->with('success', 'Parameter berhasil ditambahkan');
    }

    public function edit(ParameterLab $parameter)
    {
        return view('admin.parameters.edit', compact('parameter'));
    }

    public function update(Request $request, ParameterLab $parameter)
    {
        $validated = $request->validate([
            'kode_param' => 'required|unique:parameter_lab,kode_param,' . $parameter->id,
            'nama_param' => 'required',
            'satuan' => 'nullable',
            'nilai_normal_min' => 'nullable|numeric',
            'nilai_normal_max' => 'nullable|numeric',
            'kategori' => 'required|in:kimia_darah,urin,serologi,narkoba,lainnya',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $parameter->update($validated);

        LogAktivitas::create([
            'user_id' => auth()->user()->id,
            'aktivitas' => "Mengupdate parameter lab: {$parameter->nama_param}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'waktu' => now(),
        ]);

        // ========== NOTIFIKASI ==========

        // Notifikasi untuk petugas lab dan dokter
        $users = User::whereIn('role', ['petugas_lab', 'dokter'])->where('is_active', true)->get();
        foreach ($users as $user) {
            NotificationHelper::send(
                $user->id,
                'Parameter Lab Diperbarui',
                "Parameter lab '{$parameter->nama_param}' telah diperbarui.",
                'info',
                null
            );
        }

        return redirect()->route('admin.parameters.index')
            ->with('success', 'Parameter berhasil diupdate');
    }

    public function destroy(Request $request, ParameterLab $parameter)
    {
        $nama = $parameter->nama_param;
        $parameter->delete();

        LogAktivitas::create([
            'user_id' => auth()->user()->id,
            'aktivitas' => "Menghapus parameter lab: {$nama}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'waktu' => now(),
        ]);

        // ========== NOTIFIKASI ==========

        $users = User::whereIn('role', ['petugas_lab', 'dokter'])->where('is_active', true)->get();
        foreach ($users as $user) {
            NotificationHelper::send(
                $user->id,
                'Parameter Lab Dihapus',
                "Parameter lab '{$nama}' telah dihapus dari sistem.",
                'danger',
                null
            );
        }

        return redirect()->route('admin.parameters.index')
            ->with('success', 'Parameter berhasil dihapus');
    }
}
