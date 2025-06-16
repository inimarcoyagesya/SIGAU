<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    protected $fillable = [
        'umkm_id',
        'nama_produk',
        'deskripsi',
        'stok',
        'harga',
        'satuan',
        'expired_date',
        'gambar'
    ];

    protected $casts = [
        'expired_date' => 'date',
    ];

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class);
    }

    public function getStatusStokAttribute(): string
    {
        if ($this->stok > 20) return 'aman';
        if ($this->stok > 5) return 'sedikit';
        return 'hampir habis';
    }

    public function getStatusWarnaAttribute(): string
    {
        return match($this->status_stok) {
            'aman' => 'green',
            'sedikit' => 'yellow',
            'hampir habis' => 'red',
        };
    }
}