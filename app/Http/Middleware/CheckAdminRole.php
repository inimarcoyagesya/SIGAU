<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        if ($user && $user->role !== 'admin') {
            return redirect()->route('umkm.dashboard');
        }

        return $next($request);
    }
}