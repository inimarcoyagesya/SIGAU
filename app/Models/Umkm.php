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

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function promotions() {
        return $this->hasMany(Promotion::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

}
