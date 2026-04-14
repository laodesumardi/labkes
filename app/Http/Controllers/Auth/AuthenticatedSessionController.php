<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\LogAktivitas;
use App\Models\User;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        LogAktivitas::create([
            'user_id' => $user->id,
            'aktivitas' => 'Login ke sistem',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'waktu' => now(),
        ]);

        $user->last_login = now();
        $user->save();

        // ========== NOTIFIKASI ==========

        // Notifikasi untuk user
        NotificationHelper::send(
            $user->id,
            'Login Berhasil',
            "Anda telah login ke sistem pada " . now()->format('d/m/Y H:i:s') . " dari IP " . $request->ip(),
            'success',
            null
        );

        // Notifikasi untuk admin (jika user bukan admin)
        if ($user->role != 'admin') {
            $admins = User::where('role', 'admin')->where('is_active', true)->get();
            foreach ($admins as $admin) {
                NotificationHelper::send(
                    $admin->id,
                    'Aktivitas Login',
                    "User {$user->nama_lengkap} ({$user->role}) login pada " . now()->format('d/m/Y H:i:s') . " dari IP " . $request->ip(),
                    'info',
                    route('admin.logs.index')
                );
            }
        }

        return $this->redirectBasedOnRole($user);
    }

    private function redirectBasedOnRole($user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'dokter':
                return redirect()->route('dokter.dashboard');
            case 'petugas_lab':
                return redirect()->route('petugas_lab.dashboard');
            case 'pasien':
                return redirect()->route('pasien.dashboard');
            default:
                return redirect('/dashboard');
        }
    }

    public function destroy(Request $request)
    {
        if (Auth::check()) {
            LogAktivitas::create([
                'user_id' => Auth::id(),
                'aktivitas' => 'Logout dari sistem',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'waktu' => now(),
            ]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
