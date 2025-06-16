<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Umkm;

class CheckVerifiedUmkm
{
    public function handle($request, Closure $next)
    {
        $umkmId = $request->route('umkm');
        $umkm = Umkm::find($umkmId);
        
        if (!$umkm->verified) {
            return redirect()->back()->withErrors(['umkm' => 'Fitur iklan hanya untuk UMKM terverifikasi']);
        }

        return $next($request);
    }
}