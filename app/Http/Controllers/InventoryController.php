<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Umkm;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Menampilkan daftar inventaris
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $inventories = Inventory::with('umkm')
            ->when($search, function ($query, $search) {
                return $query->where('nama_produk', 'like', "%{$search}%")
                    ->orWhere('supplier', 'like', "%{$search}%")
                    ->orWhereHas('umkm', function ($q) use ($search) {
                        $q->where('nama_usaha', 'like', "%{$search}%");
                    });
            })
            ->paginate(10);

        $i = ($inventories->currentPage() - 1) * $inventories->perPage() + 1;

        return view('inventories.index', compact('inventories', 'i'));
    }

    /**
     * Menampilkan form untuk membuat inventaris baru
     */
    public function create()
    {
        return view('inventories.create', [
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
    public function show(Inventory $inventory)
    {
        return view('inventories.show', compact('inventory'));
    }

    /**
     * Menampilkan form untuk mengedit inventaris
     */
    public function edit(Inventory $inventory)
    {
        return view('inventories.edit', [
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

            return redirect()->route('inventories.index')
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

            return redirect()->route('inventories.index')
                ->with('success', 'Produk ' . $inventory->nama_produk . ' berhasil dihapus!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Gagal menghapus produk: ' . $th->getMessage());
        }
    }
}