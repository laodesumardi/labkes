<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class DokterMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (!in_array(Auth::user()->role, ['dokter', 'admin'])) {
            abort(403, 'Unauthorized access. Dokter only.');
        }

        return $next($request);
    }
}
