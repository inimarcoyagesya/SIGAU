<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umkm;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class PublicMapController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        
        // Default lokasi (Jakarta)
        $defaultLat = -6.2088;
        $defaultLng = 106.8456;
        
        $umkms = Umkm::query()
            ->where('status', 'active')
            ->with('category');
        
        // Filter kategori
        if ($request->category) {
            $umkms->where('category_id', $request->category);
        }
        
        // Filter rating
        if ($request->min_rating) {
            $umkms->where('rating', '>=', $request->min_rating);
        }
        
        // Filter jarak
        if ($request->current_lat && $request->current_lng) {
            $lat = $request->current_lat;
            $lng = $request->current_lng;
            $radius = $request->radius ?: 10; // Default 10 km
            
            $umkms->select('*', 
                DB::raw("(6371 * acos(cos(radians($lat)) 
                    * cos(radians(lat)) 
                    * cos(radians(lng) - radians($lng)) 
                    + sin(radians($lat)) 
                    * sin(radians(lat))) AS distance"))
                ->having('distance', '<=', $radius)
                ->orderBy('distance', 'asc');
        } else {
            $umkms->select('*', DB::raw("null as distance"));
        }
        
        $umkms = $umkms->paginate(10);
        
        // Format data untuk peta
        $mappedUmkms = $umkms->map(function($umkm) {
            return [
                'id' => $umkm->id,
                'nama_usaha' => $umkm->nama_usaha,
                'alamat' => $umkm->alamat,
                'phone' => $umkm->phone,
                'lat' => $umkm->lat,
                'lng' => $umkm->lng,
                'rating' => $umkm->rating,
                'distance' => $umkm->distance ?? null,
                'category' => $umkm->category->name ?? 'Umum'
            ];
        });
        
        return view('public.map', [
            'umkms' => $umkms,
            'mappedUmkms' => $mappedUmkms,
            'categories' => $categories
        ]);
    }
}