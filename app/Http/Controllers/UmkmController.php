<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UmkmController extends Controller
{
    /**
     * Menampilkan form untuk membuat UMKM baru.
     */
    public function create()
    {
        return view('umkms.create', [
            'categories' => Category::all()
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
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'deskripsi' => 'required|string',
            'jam_operasional' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'foto_usaha' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:pending,terverifikasi,ditolak',
        ]);

        try {
            // Upload foto usaha jika ada
            $fotoUsahaPath = null;
            if ($request->hasFile('foto_usaha')) {
                $fotoUsahaPath = $request->file('foto_usaha')->store('umkm_images', 'public');
            }

            // Associate current user and default fields
            $data = $request->only([
                'nama_usaha',
                'category_id',
                'alamat',
                'latitude',
                'longitude',
                'deskripsi',
                'jam_operasional',
                'kontak',
                'status',
            ]);
            $data['user_id'] = Auth::id();
            $data['verified_by'] = null;
            $data['foto_usaha'] = $fotoUsahaPath;

            // Create UMKM record
            $umkm = Umkm::create($data);

            // Update user role to "umkm"
            $request->user()->update(['role' => 'umkm']);

            return redirect()->route('dashboard')
                ->with('success', 'UMKM "' . $umkm->nama_usaha . '" berhasil daftarkan. menunggu verifikasi!');
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
