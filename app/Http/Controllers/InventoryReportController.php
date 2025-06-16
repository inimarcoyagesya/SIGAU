<?php

namespace App\Http\Controllers;

use App\Exports\InventoryExport;
use App\Models\Inventory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InventoryReportController extends Controller
{
    public function generatePDF()
    {
        $inventories = Inventory::with('umkm')->get();

        if ($inventories->isEmpty()) {
            return redirect()->route('inventories.index')
                             ->with('error', 'Tidak ada data inventori untuk dicetak.');
        }

        $totalStok  = $inventories->sum('stok');
        $totalNilai = $inventories->sum(fn($i) => $i->harga * $i->stok);

        $data = [
            'title'       => 'Laporan Inventori UMKM',
            'inventories' => $inventories,
            'totalStok'   => $totalStok,
            'totalNilai'  => $totalNilai,
        ];

        return Pdf::loadView('inventories.report', $data)
                  ->download('laporan-inventory-'.now()->format('Ymd').'.pdf');
    }

//     public function selectedPDF(Request $request)
// {
//     $request->validate([
//         'selected_ids' => 'required|array',
//         'selected_ids.*' => 'integer|exists:inventories,id'
//     ]);

//     $selectedIds = $request->input('selected_ids', []);
//     $inventories = Inventory::with('umkm')
//         ->whereIn('id', $selectedIds)
//         ->get();

//     if($inventories->isEmpty()) {
//         return redirect()->back()
//             ->with('error', 'Tidak ada item yang dipilih!');
//     }

//     $data = [
//         'title'       => 'Laporan Inventori Terpilih',
//         'inventories' => $inventories,
//         'totalStok'   => $inventories->sum('stok'),
//         'totalNilai'  => $inventories->sum(fn($i) => $i->harga * $i->stok),
//     ];

//     return PDF::loadView('inventories.report', $data)
//              ->download('laporan-inventori-terpilih-'.now()->format('Y-m-d').'.pdf');
// }

    public function exportExcel(Request $request)
    {
        $ids = $request->input('selected_ids', []);
        $fileName = 'inventories-'. now()->format('Ymd_His') .'.xlsx';

        return Excel::download(new InventoryExport($ids), $fileName);
    }
}
