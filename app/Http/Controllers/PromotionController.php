<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Models\Umkm;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'umkm_id' => 'required|exists:umkms,id',
            'judul_promosi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kode_kupon' => 'nullable|string|max:50',
            'masa_berlaku' => 'nullable|date',
            'link_iklan' => 'nullable|url'
        ]);

        // Validasi khusus untuk UMKM terverifikasi
        $umkm = Umkm::find($request->umkm_id);
        if (!$umkm->verified && $request->link_iklan) {
            return back()->withErrors(['link_iklan' => 'Hanya untuk UMKM terverifikasi']);
        }

        Promotion::create($request->all());

        return redirect()->back()->with('success', 'Promosi berhasil dibuat!');
    }
}