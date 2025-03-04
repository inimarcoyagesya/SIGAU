<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $promotions = Promotion::when($search, function ($query, $search) {
            return $query->where('umkm_id', 'like', "%{$search}%")
                         ->orWhere('judul_promosi', 'like', "%{$search}%")
                         ->orWhere('deskripsi', 'like', "%{$search}%")
                         ->orWhere('kode_kupon', 'like', "%{$search}%")
                         ->orWhere('masa+berlaku', 'like', "%{$search}%")
                         ->orWhere('link_iklan', 'like', "%{$search}%");
        })->paginate(10);

        // Hitung nomor urut
        $i = ($promotions->currentPage() - 1) * $promotions->perPage() + 1;

        return view('promotions.index', compact('promotions', 'i'));
    }
}
