<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UmkmProfileController extends Controller
{
    /**
     * Menampilkan form profil UMKM
     */
    public function edit()
{
    // Ambil UMKM milik user yang login
    $umkm = Umkm::where('user_id', Auth::id())->first();
    
    // Jika UMKM belum ada, buat record baru
    if (!$umkm) {
        $umkm = new Umkm();
        $umkm->user_id = Auth::id();
        $umkm->status = 'banned';
        $umkm->save();
    }
    
    // Ambil semua kategori untuk dropdown
    $categories = Category::all();
    
    // Hitung jumlah produk jika relasi ada
    try {
        $productCount = $umkm->inventories()->count();
    } catch (\Exception $e) {
        // Fallback jika relasi belum ada
        $productCount = 0;
    }
    
    return view('umkms.profile', compact('umkm', 'categories', 'productCount'));
}

    /**
     * Memperbarui profil UMKM
     */
    public function update(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_usaha' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'alamat' => 'required|string',
            'kontak' => 'required|string|max:20',
            'jam_operasional' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'foto_usaha' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
        ], [
            'nama_usaha.required' => 'Nama usaha wajib diisi',
            'category_id.required' => 'Kategori usaha wajib dipilih',
            'alamat.required' => 'Alamat wajib diisi',
            'kontak.required' => 'Kontak wajib diisi',
            'jam_operasional.required' => 'Jam operasional wajib diisi',
            'deskripsi.required' => 'Deskripsi wajib diisi',
            'foto_usaha.image' => 'File harus berupa gambar',
            'foto_usaha.mimes' => 'Format gambar yang didukung: jpeg, png, jpg, gif',
            'foto_usaha.max' => 'Ukuran gambar maksimal 5MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Ambil UMKM milik user
        $umkm = Umkm::where('user_id', Auth::id())->firstOrFail();

        // Update data
        $umkm->update([
            'nama_usaha' => $request->nama_usaha,
            'category_id' => $request->category_id,
            'alamat' => $request->alamat,
            'kontak' => $request->kontak,
            'jam_operasional' => $request->jam_operasional,
            'deskripsi' => $request->deskripsi,
        ]);

        // Handle file upload
        if ($request->hasFile('foto_usaha')) {
            // Hapus foto lama jika ada
            if ($umkm->foto_usaha) {
                Storage::delete('public/' . $umkm->foto_usaha);
            }
            
            // Simpan foto baru
            $path = $request->file('foto_usaha')->store('umkm-photos', 'public');
            $umkm->foto_usaha = $path;
            $umkm->save();
        }

        return redirect()->route('umkms.profile')->with('success', 'Profil UMKM berhasil diperbarui!');
    }

    /**
     * Menampilkan halaman profil UMKM untuk umum
     */
    public function show($id)
    {
        $umkm = Umkm::with(['user', 'category'])
            ->where('status', 'active')
            ->findOrFail($id);
            
        // Hitung rating rata-rata (contoh)
        $averageRating = $umkm->reviews()->avg('rating') ?? 0;
        
        return view('umkms.public-profile', compact('umkm', 'averageRating'));
    }
    
    /**
     * Mengupdate koordinat lokasi UMKM
     */
    public function updateLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);
        
        $umkm = Umkm::where('user_id', Auth::id())->firstOrFail();
        
        $umkm->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);
        
        return response()->json(['success' => true, 'message' => 'Lokasi berhasil diperbarui']);
    }
}