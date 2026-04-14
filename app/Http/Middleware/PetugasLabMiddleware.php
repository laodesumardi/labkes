<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PetugasLabMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (!in_array(Auth::user()->role, ['petugas_lab', 'admin'])) {
            abort(403, 'Unauthorized access. Petugas Lab only.');
        }

        return $next($request);
    }
}
