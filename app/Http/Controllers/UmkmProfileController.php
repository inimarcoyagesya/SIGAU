<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Umkm;

class UmkmProfileController extends Controller
{
    // Tampilkan profil UMKM milik user yang sedang login
    public function show()
    {
        $user = Auth::user();
        $umkm = Umkm::where('user_id', $user->id)->first();

        if (!$umkm) {
            return redirect()->route('umkm.dashboard')->with('error', 'Profil UMKM tidak ditemukan.');
        }

        return view('umkms.profile', compact('umkm'));
    }

    // Simpan perubahan profil UMKM
    public function update(Request $request)
    {
        $user = Auth::user();
        $umkm = Umkm::where('user_id', $user->id)->first();

        if (!$umkm) {
            return redirect()->route('umkm.dashboard')->with('error', 'Profil UMKM tidak ditemukan.');
        }

        $validated = $request->validate([
            'nama_usaha'     => 'required|string|max:255',
            'alamat'         => 'required|string',
            'kontak'         => 'nullable|string|max:50',
            'jam_operasional'=> 'nullable|string|max:100',
            'deskripsi'      => 'nullable|string',
        ]);

        $umkm->update($validated);

        return redirect()->route('umkm.profile')->with('success', 'Profil UMKM berhasil diperbarui.');
    }
}
