<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    public function create()
    {
        return view('umkm.register', [
            'categories' => Category::all()
        ]);
    }
}
