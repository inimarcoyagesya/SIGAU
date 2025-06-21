<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUmkmStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'umkm') {
            // Perbaikan: Jangan alihkan jika sedang mengakses halaman premium
            if (auth::user()->status === 'banned' && !$request->routeIs('umkm.premium')) {
                return redirect()->route('umkm.premium');
            }
        }
        return $next($request);
    }
}