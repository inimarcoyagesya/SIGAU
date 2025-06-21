<?php
// app/Http/Middleware/UmkmBanned.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UmkmBanned
{
    public function handle(Request $request, Closure $next)
    {
        if (auth::check() && auth::user()->role === 'umkm') {
            if (auth::user()->status !== 'banned') {
                return redirect()->route('umkm.dashboard');
            }
        } else {
            return redirect()->route('login');
        }

        return $next($request);
    }
}