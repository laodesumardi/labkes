<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAuthId
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            \Log::info('User authenticated:', [
                'id' => auth()->id(),
                'nip' => auth()->user()->nip,
                'type' => gettype(auth()->id())
            ]);
        } else {
            \Log::warning('No authenticated user');
        }

        return $next($request);
    }
}
