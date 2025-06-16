<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UmkmInventoryController extends Controller
{
    public function index()
    {
        $umkm = Umkm::where('user_id', Auth::id())->firstOrFail();
        $inventories = $umkm->inventories()->paginate(10);
        
        return view('umkms.inventories.index', compact('inventories', 'umkm'));
    }

    public function create()
    {
        return view('umkms.inventories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:20',
            'expired_date' => 'nullable|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $umkm = Umkm::where('user_id', Auth::id())->firstOrFail();

        $data = $request->except('gambar');
        
        // Handle file upload
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('inventory_images', 'public');
            $data['gambar'] = $path;
        }

        $umkm->inventories()->create($data);

        return redirect()->route('umkm.inventories.index')
            ->with('success', 'Produk berhasil ditambahkan ke inventaris');
    }

    public function edit(Inventory $inventory)
    {
        // Cek kepemilikan UMKM
        if ($inventory->umkm->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('umkms.inventories.edit', compact('inventory'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        // Cek kepemilikan UMKM
        if ($inventory->umkm->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:20',
            'expired_date' => 'nullable|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->except('gambar');
        
        // Handle file upload
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($inventory->gambar) {
                Storage::disk('public')->delete($inventory->gambar);
            }
            
            $path = $request->file('gambar')->store('inventory_images', 'public');
            $data['gambar'] = $path;
        }

        $inventory->update($data);

        return redirect()->route('umkm.inventories.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Inventory $inventory)
    {
        // Cek kepemilikan UMKM
        if ($inventory->umkm->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        
        // Delete image if exists
        if ($inventory->gambar) {
            Storage::disk('public')->delete($inventory->gambar);
        }
        
        $inventory->delete();

        return redirect()->route('umkm.inventories.index')
            ->with('success', 'Produk berhasil dihapus dari inventaris');
    }
}
}