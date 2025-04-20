<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    public function umkms()
    {
        return $this->hasMany(Umkm::class);
    }
    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }
}
