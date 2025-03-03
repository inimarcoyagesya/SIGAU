<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'umkm_id', 'nama_produk', 'harga', 
        'stok', 'supplier', 'expired_date'
    ];

    public function umkm() {
        return $this->belongsTo(Umkm::class, 'umkm_id');
    }
}
