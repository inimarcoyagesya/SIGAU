<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['user_id', 'package_id', 'transaction_id', 'amount', 'status', 'paid_at', 'payment_method', 'payment_code'];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(Umkm::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}