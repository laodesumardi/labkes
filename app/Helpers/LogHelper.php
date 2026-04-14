<?php

namespace App\Helpers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogHelper
{
    /**
     * Menambahkan log aktivitas
     *
     * @param string $aktivitas
     * @param Request|null $request
     * @return void
     */
    public static function add($aktivitas, $request = null)
    {
        try {
            LogAktivitas::create([
                'user_id' => Auth::id(), // ID integer
                'aktivitas' => $aktivitas,
                'ip_address' => $request ? $request->ip() : request()->ip(),
                'user_agent' => $request ? $request->userAgent() : request()->userAgent(),
                'waktu' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to create log: ' . $e->getMessage());
        }
    }
}
