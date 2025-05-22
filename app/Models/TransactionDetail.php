<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionDetail extends Model
{
    protected $fillable = [
        'transaction_id',
        'inventory_id',
        'quantity',
        'rental_start',
        'rental_end',
        'sub_total'
    ];

    public function rentalTransaction(): BelongsTo
    {
        return $this->belongsTo(RentalTransaction::class, 'transaction_id');
    }

    public function inventories(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }
}