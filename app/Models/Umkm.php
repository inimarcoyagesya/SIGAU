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
        'rating',
        'status',
        'jam_operasional',
        'kontak',
        'foto_usaha',
        'verified_by',
        'subscription_expired_at',
    ];

    protected $casts = [
        'subscription_expired_at' => 'datetime',
        'rating' => 'float',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    protected $appends = ['formatted_rating'];

    public function getFormattedRatingAttribute()
    {
        return number_format($this->rating, 1);
    }

    public function getFotoUrlAttribute()
    {
        return $this->foto_usaha ? asset('storage/' . $this->foto_usaha) : null;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

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
    public function inventories()
    {
        // asumsinya foreign key di tabel inventories: umkm_id
        return $this->hasMany(Inventory::class, 'umkm_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Tambahkan mutator untuk cek status aktif
    public function getIsActiveAttribute()
    {
        return $this->subscription_expired_at && $this->subscription_expired_at->isFuture();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
