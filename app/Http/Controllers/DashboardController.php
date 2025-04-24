<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Umkm;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalUmkm' => Umkm::count(),
            'verifiedUmkm' => Umkm::where('status', 'terverifikasi')->count(),
            'totalCategories' => Category::count(),
            'newRegistrations' => Umkm::whereDate('created_at', today())->count(),
            'umkmLocations' => Umkm::with('category')
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get(),
            'recentUmkms' => Umkm::latest()->take(5)->get(),
            'categoryDistribution' => Category::withCount('umkms')->get()
                ->pluck('umkms_count', 'name'),
            'registrationTrends' => Umkm::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date')
                ->get()
                ->pluck('count', 'date')
        ]);

    }
}
