<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $category = Category::when($search, function ($query, $search) {
            return $query->where('umkm_id', 'like', "%{$search}%")
                         ->orWhere('nama_produk', 'like', "%{$search}%")
                         ->orWhere('harga', 'like', "%{$search}%")
                         ->orWhere('stok', 'like', "%{$search}%")
                         ->orWhere('supplier', 'like', "%{$search}%")
                         ->orWhere('expired_date', 'like', "%{$search}%");
        })->paginate(10);

        // Hitung nomor urut
        $i = ($category->currentPage() - 1) * $category->perPage() + 1;

        return view('categories.index', compact('category', 'i'));
    }
}
