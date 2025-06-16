<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Transaction;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;

class SubscriptionController extends Controller
{
    public function show(Package $package)
    {
        return view('subscription.show', compact('package'));
    }

    public function process(Request $request, Package $package)
    {
        $user = Auth::user();
        $umkm = $user->umkm;

        $transaction = Transaction::create([
            'umkm_id' => $umkm->id,
            'package_id' => $package->id,
            'amount' => $package->price,
            'payment_status' => 'pending'
        ]);

        // Konfigurasi Midtrans
        MidtransConfig::$serverKey = config('services.midtrans.server_key');
        MidtransConfig::$isProduction = config('services.midtrans.is_production');
        MidtransConfig::$isSanitized = true;
        MidtransConfig::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->id,
                'gross_amount' => $package->price,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ]
        ];

        $snapToken = Snap::getSnapToken($params);
        $transaction->update(['snap_token' => $snapToken]);

        return view('subscription.payment', compact('snapToken'));
    }

    public function callback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        
        if ($hashed === $request->signature_key) {
            if ($request->transaction_status === 'settlement') {
                $transaction = Transaction::find($request->order_id);
                
                if ($transaction) {
                    $transaction->update([
                        'payment_status' => 'success',
                        'expires_at' => now()->addDays($transaction->package->duration)
                    ]);
                    
                    $umkm = $transaction->umkm;
                    $umkm->update([
                        'status' => 'active',
                        'subscription_expired_at' => $transaction->expires_at
                    ]);
                    
                    // Update status user jika diperlukan
                    $user = $umkm->user;
                    $user->update(['status' => 'verified']);
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }
}