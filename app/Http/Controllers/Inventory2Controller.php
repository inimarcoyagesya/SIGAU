<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Umkm;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class Inventory2Controller extends Controller
{
    /**
     * Menampilkan daftar inventaris
     */
    public function index()
    {
        // Ambil UMKM yang punya inventory (distinct)
        $umkms = Umkm::whereHas('inventories')->pluck('nama_usaha', 'id');

        // View awal tanpa data
        return view('inventories2.index', [
            'umkms' => $umkms,
        ]);
    }


    /**
     * Menampilkan form untuk membuat inventaris baru
     */
    public function create()
    {
        return view('inventories2.create', [
            'umkms' => Umkm::all()
        ]);
    }

    /**
     * Menyimpan inventaris baru ke database
     */
    public function store(Request $request)
    {
        $request->merge([
            'harga' => (float) str_replace(['Rp', '.', ' '], '', $request->harga)
        ]);

        $request->validate([
            'umkm_id' => 'required|exists:umkms,id',
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'supplier' => 'required|string|max:255',
            'expired_date' => 'nullable|date',
        ]);

        try {
            Inventory::create($request->all());

            return redirect()->route('inventories.index')
                ->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Gagal menambahkan produk: ' . $th->getMessage());
        }
    }

    /**
     * Menampilkan detail inventaris
     */
    // public function show(Inventory $inventory)
    // {
    //     return view('inventories2.show', compact('inventory'));
    // }

    /**
     * Menampilkan form untuk mengedit inventaris
     */
    public function edit(Inventory $inventory)
    {
        return view('inventories2.edit', [
            'inventory' => $inventory,
            'umkms' => Umkm::all()
        ]);
    }

    /**
     * Memperbarui inventaris di database
     */
    public function update(Request $request, Inventory $inventory)
    {
        $request->merge([
            'harga' => (float) str_replace(['Rp', '.', ' '], '', $request->harga)
        ]);

        $request->validate([
            'umkm_id' => 'required|exists:umkms,id',
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'supplier' => 'required|string|max:255',
            'expired_date' => 'nullable|date',
        ]);

        try {
            $inventory->update($request->all());

            return redirect()->route('inventories2.index')
                ->with('success', 'Produk ' . $inventory->nama_produk . ' berhasil diperbarui!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Gagal memperbarui produk: ' . $th->getMessage());
        }
    }

    /**
     * Menghapus inventaris dari database
     */
    public function destroy(Inventory $inventory)
    {
        try {
            $inventory->delete();

            return redirect()->route('inventories2.index')
                ->with('success', 'Produk ' . $inventory->nama_produk . ' berhasil dihapus!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Gagal menghapus produk: ' . $th->getMessage());
        }
    }
    public function filter(Request $request)
    {
        \Log::info('Filter inventories2 called', $request->all());

        $query = Inventory::with('umkm');

        if ($request->start) {
            $query->whereDate('expired_date', '>=', $request->start);
        }
        if ($request->end) {
            $query->whereDate('expired_date', '<=', $request->end);
        }
        if ($request->umkm) {
            $query->where('umkm_id', $request->umkm);
        }

        $items = $query->get()->map(function ($inv) {
            return [
                'id'        => $inv->id,
                'nama_produk' => $inv->nama_produk,
                'umkm'      => ['nama_usaha' => $inv->umkm->nama_usaha],
                'harga'     => $inv->harga,
                'stok'      => $inv->stok,
                'supplier'  => $inv->supplier,
                'expired_date_formatted' => $inv->expired_date
                    ? $inv->expired_date->format('d/m/Y')
                    : null,
            ];
        });

        \Log::info('Filter result count: ' . $items->count());

        return response()->json($items);
    }
}
