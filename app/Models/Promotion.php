<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'umkm_id', 'judul_promosi', 'deskripsi', 
        'kode_kupon', 'masa_berlaku', 'link_iklan'
    ];

    public function umkm() {
        return $this->belongsTo(Umkm::class, 'umkm_id');
    }
}
