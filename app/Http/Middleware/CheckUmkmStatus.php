<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUmkmStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && auth::user()->role === 'umkm') {
            if (auth::user()->status === 'banned') {
                return redirect()->route('umkm.penalty');
            }
        }

        return $next($request);
    }
}