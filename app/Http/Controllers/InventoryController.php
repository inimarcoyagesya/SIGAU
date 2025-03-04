<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $inventory = Inventory::when($search, function ($query, $search) {
            return $query->where('umkm_id', 'like', "%{$search}%")
                         ->orWhere('nama_produk', 'like', "%{$search}%")
                         ->orWhere('harga', 'like', "%{$search}%")
                         ->orWhere('stok', 'like', "%{$search}%")
                         ->orWhere('supplier', 'like', "%{$search}%")
                         ->orWhere('expired_date', 'like', "%{$search}%");
        })->paginate(10);

        // Hitung nomor urut
        $i = ($inventory->currentPage() - 1) * $inventory->perPage() + 1;

        return view('inventories.index', compact('inventory', 'i'));
    }
}
