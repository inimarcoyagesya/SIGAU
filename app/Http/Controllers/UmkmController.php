<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    /**
     * Menampilkan form untuk membuat UMKM baru.
     */
    public function create()
    {
        return view('umkms.create', [
            'categories' => Category::all() // Mengirim data kategori ke view
        ]);
    }

    /**
     * Menampilkan daftar UMKM.
     */
    public function index(Request $request)
    {
        $search = $request->input('search'); // Ambil parameter pencarian

        $umkms = Umkm::when($search, function ($query, $search) {
            return $query->where('nama_usaha', 'like', "%{$search}%")
                         ->orWhere('alamat', 'like', "%{$search}%")
                         ->orWhere('deskripsi', 'like', "%{$search}%")
                         ->orWhere('kontak', 'like', "%{$search}%")
                         ->orWhereHas('category', function ($q) use ($search) {
                             $q->where('nama_kategori', 'like', "%{$search}%");
                         });
        })->paginate(10);

        // Hitung nomor urut
        $i = ($umkms->currentPage() - 1) * $umkms->perPage() + 1;

        return view('umkms.index', compact('umkms', 'i'));
    }

    /**
     * Menyimpan UMKM baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'alamat' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'deskripsi' => 'required|string',
            'jam_operasional' => 'required|string',
            'kontak' => 'required|string',
            'foto_usaha' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status_verifikasi' => 'required|in:pending,terverifikasi,ditolak',
        ]);

        try {
            // Upload foto usaha
            $fotoUsahaPath = $request->file('foto_usaha')->store('umkm_images', 'public');

            // Simpan data UMKM
            $umkm = new Umkm([
                'nama_usaha' => $request->nama_usaha,
                'category_id' => $request->category_id,
                'alamat' => $request->alamat,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'deskripsi' => $request->deskripsi,
                'jam_operasional' => $request->jam_operasional,
                'kontak' => $request->kontak,
                'foto_usaha' => $fotoUsahaPath,
                'status_verifikasi' => $request->status_verifikasi,
                'user_id' => Auth()::id(), // Jika menggunakan auth, ambil ID user yang login
            ]);

            $umkm->save();

            return redirect()->route('umkms.index')
                ->with('success', 'UMKM ' . $umkm->nama_usaha . ' berhasil ditambahkan!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Gagal menambahkan UMKM: ' . $th->getMessage());
        }
    }

    /**
     * Menampilkan detail UMKM.
     */
    public function show(Umkm $umkm)
    {
        return view('umkms.show', compact('umkm'));
    }

    /**
     * Menampilkan form untuk mengedit UMKM.
     */
    public function edit(Umkm $umkm)
    {
        return view('umkms.edit', [
            'umkm' => $umkm,
            'categories' => Category::all() // Mengirim data kategori ke view
        ]);
    }

    /**
     * Memperbarui data UMKM di database.
     */
    public function update(Request $request, Umkm $umkm)
    {
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'alamat' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'deskripsi' => 'required|string',
            'jam_operasional' => 'required|string',
            'kontak' => 'required|string',
            'foto_usaha' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status_verifikasi' => 'required|in:pending,terverifikasi,ditolak',
        ]);

        try {
            // Update foto usaha jika ada
            if ($request->hasFile('foto_usaha')) {
                // Hapus foto lama jika ada
                if ($umkm->foto_usaha && Storage::disk('public')->exists($umkm->foto_usaha)) {
                    Storage::disk('public')->delete($umkm->foto_usaha);
                }
                // Upload foto baru
                $fotoUsahaPath = $request->file('foto_usaha')->store('umkm_images', 'public');
                $umkm->foto_usaha = $fotoUsahaPath;
            }

            // Update data UMKM
            $umkm->update([
                'nama_usaha' => $request->nama_usaha,
                'category_id' => $request->category_id,
                'alamat' => $request->alamat,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'deskripsi' => $request->deskripsi,
                'jam_operasional' => $request->jam_operasional,
                'kontak' => $request->kontak,
                'status_verifikasi' => $request->status_verifikasi,
            ]);

            return redirect()->route('umkms.index')
                ->with('success', 'UMKM ' . $umkm->nama_usaha . ' berhasil diperbarui!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Gagal memperbarui UMKM: ' . $th->getMessage());
        }
    }

    /**
     * Menghapus UMKM dari database.
     */
    public function destroy(Umkm $umkm)
    {
        try {
            // Hapus foto usaha jika ada
            if ($umkm->foto_usaha && Storage::disk('public')->exists($umkm->foto_usaha)) {
                Storage::disk('public')->delete($umkm->foto_usaha);
            }

            $umkm->delete();

            return redirect()->route('umkms.index')
                ->with('success', 'UMKM ' . $umkm->nama_usaha . ' berhasil dihapus!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Gagal menghapus UMKM: ' . $th->getMessage());
        }
    }
}