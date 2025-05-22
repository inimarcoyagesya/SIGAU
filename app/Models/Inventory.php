<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'umkm_id', 'nama_produk', 'harga', 
        'stok', 'supplier', 'expired_date'
    ];

    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }


    public function umkm() {
        return $this->belongsTo(Umkm::class, 'umkm_id');
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
