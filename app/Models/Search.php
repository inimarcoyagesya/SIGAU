<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $fillable = ['keyword', 'kategori_filter', 'radius', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
