<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Promotion;
use App\Models\PromotionStatistic;
use Illuminate\Http\Client\Request;

class PromotionPageController extends Controller
{
    public function show($id)
    {
        $umkm = Umkm::with(['promotions', 'inventories' => function($query) {
            $query->whereNotNull('gambar'); // Asumsi kolom gambar ada
        }])->findOrFail($id);

        // Update statistik
        $today = now()->toDateString();
        $statistic = PromotionStatistic::firstOrCreate(
            ['promotion_id' => $umkm->id, 'date' => $today],
            ['views' => 0, 'clicks' => 0]
        );
        $statistic->increment('views');

        return view('promotion_page.show', compact('umkm'));
    }

    public function trackClick(Request $request, Promotion $promotion)
{
    $today = now()->toDateString();
    $statistic = PromotionStatistic::firstOrCreate(
        ['promotion_id' => $promotion->id, 'date' => $today],
        ['views' => 0, 'clicks' => 0]
    );
    
    $statistic->increment('clicks');
    
    return response()->json(['status' => 'success']);
}
}
