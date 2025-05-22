<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Category;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Pie chart: distribusi kategori
        $categories = Category::withCount('umkms')->get();
        $filteredCategories = $categories->filter(fn($cat) => $cat->umkms_count > 0);
        $hasCategoryData = $filteredCategories->isNotEmpty();

        $pieChart = null;
        if ($hasCategoryData) {
            $pieChart = (new LarapexChart)
                ->pieChart()
                ->setTitle('Distribusi Kategori UMKM')
                ->setLabels($filteredCategories->pluck('name')->toArray())
                ->setDataset($filteredCategories->pluck('umkms_count')->toArray());
        }

        // 2. Data ringkas
        $totalUmkm         = Umkm::count();
        $verifiedUmkm      = Umkm::where('status', 'terverifikasi')->count();
        $totalCategories   = Category::count();
        $newRegistrations  = Umkm::whereDate('created_at', today())->count();
        $umkmLocations     = Umkm::with('category')
                                 ->whereNotNull('latitude')
                                 ->whereNotNull('longitude')
                                 ->get();
        $recentUmkms       = Umkm::latest()->take(5)->get();

        // 3. Line chart: tren pendaftaran harian
        $registrationTrends = Umkm::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');  // Collection [ '2025-05-20' => 3, ... ]

        $lineChart = null;
        if ($registrationTrends->isNotEmpty()) {
            $dates  = $registrationTrends->keys()->toArray();
            $counts = $registrationTrends->values()->toArray();

            $lineChart = (new LarapexChart)
                ->lineChart()
                ->setTitle('Tren Pendaftaran UMKM per Hari')
                ->setXAxis($dates)
                ->setDataset([
                    [
                        'name' => 'Pendaftaran',
                        'data' => $counts,
                    ],
                ]);
        }

        $mappedData = $umkmLocations->map(function($u) {
            return [
                'lat' => $u->latitude,
                'lng' => $u->longitude,
                'nama' => $u->nama_usaha,
                'kategori' => $u->category->name ?? '—',
            ];
        });

        // 4. Kirim ke view
        return view('dashboard', [
            'totalUmkm'       => $totalUmkm,
            'verifiedUmkm'    => $verifiedUmkm,
            'totalCategories' => $totalCategories,
            'newRegistrations'=> $newRegistrations,
            'umkmLocations'   => $umkmLocations,
            'recentUmkms'     => $recentUmkms,
            'chart'           => $pieChart,
            'hasCategoryData' => $hasCategoryData,
            'registrationTrends' => $registrationTrends,
            'lineChart'       => $lineChart,
            'mappedLocations' => $mappedData
        ]);
    }
}
