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
        // Ambil UMKM milik user yang login
    $userUmkm = Umkm::where('user_id', Auth::Id())->first();
        
        // Statistik dummy (dalam implementasi nyata, ambil dari database)
        $salesThisMonth = 15000000;
        $visitorCount = 320;
        
        

        $mappedCompetitors = [];
        // Ambil kompetitor terdekat (dalam radius 5km)
        $competitors = collect();
        
        if ($userUmkm && $userUmkm->latitude && $userUmkm->longitude) {
            $userLat = $userUmkm->latitude;
            $userLng = $userUmkm->longitude;
            $radius = 5; // dalam kilometer
            
            $competitors = Umkm::select('*')
                ->selectRaw("
                    (6371 * acos(cos(radians(?)) 
                    * cos(radians(latitude)) 
                    * cos(radians(longitude) - radians(?)) 
                    + sin(radians(?)) 
                    * sin(radians(latitude)))) 
                    AS distance
                ", [$userLat, $userLng, $userLat])
                ->where('id', '!=', $userUmkm->id)
                ->where('status', 'active')
                ->havingRaw('distance < ?', [$radius])
                ->orderBy('distance')
                ->take(3)
                ->get()
                ->map(function ($item) {
                    // Konversi distance ke float
                    $item->distance = (float) $item->distance;
                    return $item;
                });
        }
                
        //     $mappedCompetitors = $competitors->map(function($comp) {
        //         return [
        //             'id' => $comp->id,
        //             'nama_usaha' => $comp->nama_usaha,
        //             'alamat' => $comp->alamat,
        //             'lat' => $comp->lat,
        //             'lng' => $comp->lng,
        //             'distance' => $comp->distance
        //         ];
        //     });
        // }
        
        return view('umkms.dashboard', [
            'user' => $user,
            'umkm' => $umkm,
            'userUmkm' => $userUmkm,
            'salesThisMonth' => $salesThisMonth,
            'visitorCount' => $visitorCount,
            'competitors' => $competitors,
            'mappedCompetitors' => $mappedCompetitors,
            'hasLocations' => $umkm && $umkm->lat && $umkm->lng
        ]);
    }
}