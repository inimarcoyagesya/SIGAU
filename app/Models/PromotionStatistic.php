<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionStatistic extends Model
{
    protected $fillable = ['promotion_id', 'date', 'views', 'clicks'];
    
    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
}
