<?php

namespace App\Exports;

use App\Invoice;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{
    public function view(): View
    {
        return view('users.excel', [
            'data' => User::all()
        ]);
    }
}