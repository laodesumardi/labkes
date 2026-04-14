<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LogAktivitas;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:users',
            'nama_lengkap' => 'required',
            'email' => 'nullable|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,dokter,petugas_lab,pasien',
            'no_telepon' => 'nullable',
            'alamat' => 'nullable',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        LogAktivitas::create([
            'user_id' => Auth::user()->id,
            'aktivitas' => "Menambah user baru: {$user->nama_lengkap} ({$user->nip})",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'waktu' => now(),
        ]);

        // ========== NOTIFIKASI ==========

        // 1. Notifikasi untuk user baru
        NotificationHelper::send(
            $user->id,
            'Selamat Datang',
            "Selamat datang di Sistem Laboratorium Kesehatan. Akun Anda telah dibuat dengan role " . ucfirst($user->role),
            'success',
            route('login')
        );

        // 2. Notifikasi untuk admin lain
        $admins = User::where('role', 'admin')->where('id', '!=', Auth::id())->where('is_active', true)->get();
        foreach ($admins as $admin) {
            NotificationHelper::send(
                $admin->id,
                'User Baru Ditambahkan',
                "User baru dengan nama {$user->nama_lengkap} (Role: " . ucfirst($user->role) . ") ditambahkan oleh " . Auth::user()->nama_lengkap,
                'info',
                route('admin.users.index')
            );
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,dokter,petugas_lab,pasien',
            'no_telepon' => 'nullable',
            'alamat' => 'nullable',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'is_active' => 'boolean',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        LogAktivitas::create([
            'user_id' => Auth::user()->id,
            'aktivitas' => "Mengupdate user: {$user->nama_lengkap}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'waktu' => now(),
        ]);

        // ========== NOTIFIKASI ==========

        NotificationHelper::send(
            $user->id,
            'Data Akun Diperbarui',
            'Data akun Anda telah diperbarui oleh administrator.',
            'info',
            route('profile.edit')
        );

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diupdate');
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $userId = $user->id;
        $userName = $user->nama_lengkap;
        $user->delete();

        LogAktivitas::create([
            'user_id' => Auth::user()->id,
            'aktivitas' => "Menghapus user: {$userName}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'waktu' => now(),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus');
    }
}
