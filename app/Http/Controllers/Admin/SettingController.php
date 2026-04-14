<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use App\Models\LogAktivitas;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'app_name' => Setting::get('app_name', 'Laboratorium Kesehatan'),
            'app_logo' => Setting::get('app_logo', null),
            'login_background' => Setting::get('login_background', null),
            'primary_color' => Setting::get('primary_color', '#004b23'),
            'favicon' => Setting::get('favicon', null),
        ];

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:100',
            'primary_color' => 'nullable|string|max:20',
        ]);

        Setting::set('app_name', $request->app_name, 'text', 'general');

        if ($request->primary_color) {
            Setting::set('primary_color', $request->primary_color, 'text', 'appearance');
        }

        if ($request->hasFile('app_logo')) {
            $request->validate([
                'app_logo' => 'image|mimes:png,jpg,jpeg|max:2048'
            ]);

            $oldLogo = Setting::get('app_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            $logoPath = $request->file('app_logo')->store('settings/logos', 'public');
            Setting::set('app_logo', $logoPath, 'image', 'appearance');
        }

        if ($request->hasFile('login_background')) {
            $request->validate([
                'login_background' => 'image|mimes:png,jpg,jpeg|max:5120'
            ]);

            $oldBg = Setting::get('login_background');
            if ($oldBg && Storage::disk('public')->exists($oldBg)) {
                Storage::disk('public')->delete($oldBg);
            }

            $bgPath = $request->file('login_background')->store('settings/backgrounds', 'public');
            Setting::set('login_background', $bgPath, 'image', 'appearance');
        }

        if ($request->hasFile('favicon')) {
            $request->validate([
                'favicon' => 'image|mimes:png,ico|max:512'
            ]);

            $oldFavicon = Setting::get('favicon');
            if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                Storage::disk('public')->delete($oldFavicon);
            }

            $faviconPath = $request->file('favicon')->store('settings/favicons', 'public');
            Setting::set('favicon', $faviconPath, 'image', 'appearance');
        }

        LogAktivitas::create([
            'user_id' => Auth::user()->id,
            'aktivitas' => 'Mengupdate pengaturan sistem',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'waktu' => now(),
        ]);

        // ========== NOTIFIKASI ==========

        // Notifikasi untuk semua user (opsional)
        $allUsers = User::where('is_active', true)->get();
        foreach ($allUsers as $user) {
            NotificationHelper::send(
                $user->id,
                'Pengaturan Sistem Diperbarui',
                "Pengaturan sistem telah diperbarui oleh administrator.",
                'info',
                null
            );
        }

        return redirect()->route('admin.settings')
            ->with('success', 'Pengaturan berhasil disimpan');
    }

    public function resetLogo(Request $request)
    {
        $oldLogo = Setting::get('app_logo');
        if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
            Storage::disk('public')->delete($oldLogo);
        }
        Setting::set('app_logo', null);

        LogAktivitas::create([
            'user_id' => Auth::user()->id,
            'aktivitas' => 'Meriset logo aplikasi',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'waktu' => now(),
        ]);

        return redirect()->route('admin.settings')
            ->with('success', 'Logo berhasil direset');
    }

    public function resetBackground(Request $request)
    {
        $oldBg = Setting::get('login_background');
        if ($oldBg && Storage::disk('public')->exists($oldBg)) {
            Storage::disk('public')->delete($oldBg);
        }
        Setting::set('login_background', null);

        LogAktivitas::create([
            'user_id' => Auth::user()->id,
            'aktivitas' => 'Meriset background login',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'waktu' => now(),
        ]);

        return redirect()->route('admin.settings')
            ->with('success', 'Background berhasil direset');
    }
}
