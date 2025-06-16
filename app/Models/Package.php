<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Package extends Model
{
    protected $fillable = [
        'id',
        'name',
        'description',
        'price',
        'duration',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Accessor untuk format harga
    protected function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp ' . number_format($this->price, 0, ',', '.')
        );
    }

    // Accessor untuk format durasi
    protected function formattedDuration(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->duration >= 30) {
                    $months = floor($this->duration / 30);
                    return $months . ' ' . ($months > 1 ? 'Bulan' : 'Bulan');
                }
                return $this->duration . ' Hari';
            }
        );
    }

    // Relasi dengan transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}