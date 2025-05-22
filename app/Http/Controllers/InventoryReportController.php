<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Client\Request;

class InventoryReportController extends Controller
{
    public function generatePDF()
    {
        // Pastikan data ada
        $inventories = Inventory::with('umkm')->get();
        
        if($inventories->isEmpty()) {
            abort(404, 'Data inventory tidak ditemukan');
        }

        $data = [
            'title' => 'Laporan Inventori UMKM',
            'inventories' => $inventories,
            'totalStok' => $inventories->sum('stok'),
            'totalNilai' => $inventories->sum(function($item) {
                return $item->harga * $item->stok;
            })
        ];

        // Pastikan view ada
        if (!view()->exists('inventories.report')) {
            abort(404, 'Template laporan tidak ditemukan');
        }

        return PDF::loadView('inventories.report', $data)
                 ->stream('laporan-inventori-'.date('Y-m-d').'.pdf');
    }

//     public function selectedPDF(Request $request)
// {
//     $request->validate([
//         'selected_ids' => 'required|array',
//         'selected_ids.*' => 'integer|exists:inventories,id'
//     ]);

//     $selectedIds = $request->selected_ids;
    
//     $inventories = Inventory::with('umkm')
//         ->whereIn('id', $selectedIds)
//         ->get();

//     if($inventories->isEmpty()) {
//         return redirect()->back()
//             ->with('error', 'Tidak ada item yang dipilih!');
//     }

//     $data = [
//         'title' => 'Laporan Inventori Terpilih',
//         'inventories' => $inventories,
//         'totalStok' => $inventories->sum('stok'),
//         'totalNilai' => $inventories->sum(function($item) {
//             return $item->harga * $item->stok;
//         })
//     ];

//     return PDF::loadView('inventories.report', $data)
//              ->stream('laporan-inventori-terpilih-'.date('Y-m-d').'.pdf');
// }
}