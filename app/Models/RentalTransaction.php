<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RentalTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'umkm_id',
        'transaction_date',
        'total_amount',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(UMKM::class);
    }

    public function transactionDetails(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}