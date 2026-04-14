<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

// Halaman utama redirect ke login
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'dokter':
                return redirect()->route('dokter.dashboard');
            case 'petugas_lab':
                return redirect()->route('petugas_lab.dashboard');
            default:
                return redirect()->route('pasien.dashboard');
        }
    }
    return redirect('/login');
});

// Auth routes - hanya login
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==================== NOTIFICATION ROUTES ====================
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread', [NotificationController::class, 'getUnread'])->name('notifications.unread');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
});

// ==================== ADMIN ROUTES ====================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::resource('parameters', App\Http\Controllers\Admin\ParameterController::class);
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/harian', [App\Http\Controllers\Admin\ReportController::class, 'harian'])->name('reports.harian');
    Route::get('/reports/bulanan', [App\Http\Controllers\Admin\ReportController::class, 'bulanan'])->name('reports.bulanan');
    Route::get('/reports/tahunan', [App\Http\Controllers\Admin\ReportController::class, 'tahunan'])->name('reports.tahunan');
    Route::get('/logs', [App\Http\Controllers\Admin\LogController::class, 'index'])->name('logs.index');
    Route::delete('/logs/clear', [App\Http\Controllers\Admin\LogController::class, 'clear'])->name('logs.clear');
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings');
    Route::put('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    Route::get('/settings/reset-logo', [App\Http\Controllers\Admin\SettingController::class, 'resetLogo'])->name('settings.reset-logo');
    Route::get('/settings/reset-background', [App\Http\Controllers\Admin\SettingController::class, 'resetBackground'])->name('settings.reset-background');
});

// ==================== DOKTER ROUTES ====================
Route::prefix('dokter')->name('dokter.')->middleware(['auth', 'dokter'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Dokter\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pemeriksaan', [App\Http\Controllers\Dokter\PemeriksaanController::class, 'index'])->name('pemeriksaan.index');
    Route::get('/pemeriksaan/{id}', [App\Http\Controllers\Dokter\PemeriksaanController::class, 'show'])->name('pemeriksaan.show');
    Route::get('/pemeriksaan/{id}/edit', [App\Http\Controllers\Dokter\PemeriksaanController::class, 'edit'])->name('pemeriksaan.edit');
    Route::put('/pemeriksaan/{id}', [App\Http\Controllers\Dokter\PemeriksaanController::class, 'update'])->name('pemeriksaan.update');
    Route::get('/rekam-medis', [App\Http\Controllers\Dokter\RekamMedisController::class, 'index'])->name('rekam-medis.index');
    Route::get('/rekam-medis/{id}', [App\Http\Controllers\Dokter\RekamMedisController::class, 'show'])->name('rekam-medis.show');
    Route::get('/validasi', [App\Http\Controllers\Dokter\ValidasiController::class, 'index'])->name('validasi.index');
    Route::post('/validasi/{id}', [App\Http\Controllers\Dokter\ValidasiController::class, 'validate'])->name('validasi.validate');
    Route::post('/validasi/{id}/batal', [App\Http\Controllers\Dokter\ValidasiController::class, 'cancel'])->name('validasi.cancel');
});

// ==================== PETUGAS LAB ROUTES ====================
Route::prefix('petugas-lab')->name('petugas_lab.')->middleware(['auth', 'petugas_lab'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\PetugasLab\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pemeriksaan', [App\Http\Controllers\PetugasLab\PemeriksaanController::class, 'index'])->name('pemeriksaan.index');
    Route::get('/pemeriksaan/create', [App\Http\Controllers\PetugasLab\PemeriksaanController::class, 'create'])->name('pemeriksaan.create');
    Route::post('/pemeriksaan', [App\Http\Controllers\PetugasLab\PemeriksaanController::class, 'store'])->name('pemeriksaan.store');
    Route::get('/pemeriksaan/{id}/edit', [App\Http\Controllers\PetugasLab\PemeriksaanController::class, 'edit'])->name('pemeriksaan.edit');
    Route::put('/pemeriksaan/{id}', [App\Http\Controllers\PetugasLab\PemeriksaanController::class, 'update'])->name('pemeriksaan.update');
    Route::delete('/pemeriksaan/{id}', [App\Http\Controllers\PetugasLab\PemeriksaanController::class, 'destroy'])->name('pemeriksaan.destroy');
    Route::get('/hasil-lab/{id}/edit', [App\Http\Controllers\PetugasLab\HasilLabController::class, 'edit'])->name('hasil-lab.edit');
    Route::put('/hasil-lab/{id}', [App\Http\Controllers\PetugasLab\HasilLabController::class, 'update'])->name('hasil-lab.update');
    Route::get('/antrian', [App\Http\Controllers\PetugasLab\AntrianController::class, 'index'])->name('antrian.index');
    Route::post('/antrian', [App\Http\Controllers\PetugasLab\AntrianController::class, 'store'])->name('antrian.store');
    Route::put('/antrian/{id}/proses', [App\Http\Controllers\PetugasLab\AntrianController::class, 'proses'])->name('antrian.proses');
    Route::put('/antrian/{id}/selesai', [App\Http\Controllers\PetugasLab\AntrianController::class, 'selesai'])->name('antrian.selesai');
    Route::get('/cetak', [App\Http\Controllers\PetugasLab\CetakController::class, 'index'])->name('cetak.index');
    Route::get('/cetak/{id}', [App\Http\Controllers\PetugasLab\CetakController::class, 'show'])->name('cetak.show');
});

// ==================== PASIEN ROUTES ====================
Route::prefix('pasien')->name('pasien.')->middleware(['auth', 'pasien'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Pasien\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/riwayat', [App\Http\Controllers\Pasien\RiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/{id}', [App\Http\Controllers\Pasien\RiwayatController::class, 'show'])->name('riwayat.show');
    Route::get('/hasil', [App\Http\Controllers\Pasien\HasilController::class, 'index'])->name('hasil.index');
    Route::get('/hasil/{id}', [App\Http\Controllers\Pasien\HasilController::class, 'show'])->name('hasil.show');
    Route::get('/hasil/{id}/pdf', [App\Http\Controllers\Pasien\HasilController::class, 'downloadPdf'])->name('hasil.pdf');
});



Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==================== NOTIFICATION ROUTES ====================
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread', [NotificationController::class, 'getUnread'])->name('notifications.unread');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
});
