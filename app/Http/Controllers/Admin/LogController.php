<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $logs = LogAktivitas::with('user')
            ->orderBy('waktu', 'desc')
            ->paginate(50);

        return view('admin.logs', compact('logs'));
    }

    public function clear(Request $request)
    {
        // Log aktivitas sebelum menghapus
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Menghapus semua log aktivitas',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'waktu' => now(),
        ]);

        // Hapus semua log
        LogAktivitas::truncate();

        return redirect()->route('admin.logs.index')
            ->with('success', 'Semua log aktivitas berhasil dihapus');
    }
}
