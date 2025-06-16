<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenaltyPayment extends Model
{
    protected $fillable = [
        'user_id','amount','method','ewallet_type',
        'proof_path','status','paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
