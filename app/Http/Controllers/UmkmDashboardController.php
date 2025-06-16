<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UmkmDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $umkm = $user->umkm;
        
        // Statistik dummy (dalam implementasi nyata, ambil dari database)
        $salesThisMonth = 15000000;
        $visitorCount = 320;
        
        // Ambil kompetitor terdekat (dalam kategori yang sama)
        $competitors = [];
        $mappedCompetitors = [];
        
        if ($umkm && $umkm->lat && $umkm->lng) {
            $competitors = Umkm::select('*', 
                    DB::raw("(6371 * acos(cos(radians($umkm->lat)) 
                        * cos(radians(lat)) 
                        * cos(radians(lng) - radians($umkm->lng)) 
                        + sin(radians($umkm->lat)) 
                        * sin(radians(lat))) AS distance"))
                ->where('category_id', $umkm->category_id)
                ->where('id', '!=', $umkm->id)
                ->where('status', 'active')
                ->orderBy('distance', 'asc')
                ->limit(5)
                ->get();
                
            $mappedCompetitors = $competitors->map(function($comp) {
                return [
                    'id' => $comp->id,
                    'nama_usaha' => $comp->nama_usaha,
                    'alamat' => $comp->alamat,
                    'lat' => $comp->lat,
                    'lng' => $comp->lng,
                    'distance' => $comp->distance
                ];
            });
        }
        
        return view('umkms.dashboard', [
            'user' => $user,
            'umkm' => $umkm,
            'salesThisMonth' => $salesThisMonth,
            'visitorCount' => $visitorCount,
            'competitors' => $competitors,
            'mappedCompetitors' => $mappedCompetitors,
            'hasLocations' => $umkm && $umkm->lat && $umkm->lng
        ]);
    }
}