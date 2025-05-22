<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RentalItem extends Model
{
    protected $fillable = [
        'umkm_id',
        'category_id',
        'name',
        'description',
        'rental_price_per_day',
        'availability_status'
    ];

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(UMKM::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function transactionDetails(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }
}