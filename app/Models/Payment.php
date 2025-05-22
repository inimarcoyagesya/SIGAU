<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'transaction_id',
        'payment_date',
        'amount',
        'method',
        'status'
    ];

    public function rentalTransaction(): BelongsTo
    {
        return $this->belongsTo(RentalTransaction::class, 'transaction_id');
    }
}