<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PasienMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (!in_array(Auth::user()->role, ['pasien', 'admin'])) {
            abort(403, 'Unauthorized access. Pasien only.');
        }

        return $next($request);
    }
}
