<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UmkmPenaltyController extends Controller
{
    public function show()
    {
        if (Auth::user()->status !== 'banned') {
            return redirect()->route('umkm.dashboard');
        }

        return view('umkms.penalty', [
            'penalty_fee' => Auth::user()->penalty_fee,
            'ban_reason' => Auth::user()->ban_reason
        ]);
    }

    public function pay(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:bca,gopay,credit_card'
        ]);
        
        /** @var User $user */
        $user = Auth::user();
        
        $user->status = 'active';
        $user->ban_reason = null;
        $user->penalty_fee = 0;
        $user->save();

        return redirect()->route('umkm.dashboard')
            ->with('success', 'Pembayaran denda berhasil! Akun Anda telah diaktifkan kembali.');
    }
}