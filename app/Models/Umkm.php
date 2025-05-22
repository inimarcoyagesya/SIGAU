<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    protected $fillable = [
        'user_id',
        'nama_usaha',
        'category_id',
        'alamat',
        'latitude',
        'longitude',
        'deskripsi',
        'status',
        'jam_operasional',
        'kontak',
        'foto_usaha',
        'verified_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function rentalItems()
    {
        return $this->hasMany(RentalItem::class);
    }

    public function rentalTransactions()
    {
        return $this->hasMany(RentalTransaction::class);
    }
    public function inventories()
    {
        // asumsinya foreign key di tabel inventories: umkm_id
        return $this->hasMany(Inventory::class, 'umkm_id');
    }
}
