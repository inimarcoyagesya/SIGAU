<?php

// App\Http\Controllers\PremiumController.php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Subscription;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PremiumController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $packages = Package::where('status', 'aktif')->get();
        $user = Auth::user();
        
        $activeSubscription = null;
        if ($user && !$user->is_banned) {
            $activeSubscription = Subscription::where('user_id', $user->id)
                ->where('status', 'active')
                ->with('package')
                ->first();
        }

        return view('umkms.premium-transaction', compact('packages', 'activeSubscription'));
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id'
        ]);

        $user = Auth::user();
        // Cek jika user dibanned
    if ($user->is_banned) {
        return redirect()->route('premium.index')->with('error', 'Akun Anda dibanned. Tidak dapat melakukan transaksi.');
    }
        $package = Package::find($request->package_id);

        // Cek apakah pengguna sudah memiliki langganan aktif
        $activeSubscription = Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        if ($activeSubscription) {
            return redirect()->back()->with('error', 'Anda sudah memiliki langganan aktif.');
        }

        // Buat transaksi baru
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'amount' => $package->price,
            'payment_method' => 'qris',
            'payment_code' => 'PREMIUM-' . Str::random(8),
            'status' => 'pending'
        ]);

        // Redirect ke halaman pembayaran
        return redirect()->route('payment.show', $transaction->id);
    }

    public function showPayment(Transaction $transaction)
    {
        // Pastikan transaksi milik user yang login
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Hitung waktu kedaluwarsa (contoh: 1 jam dari sekarang)
        $expiryTime = now()->addHours(1);
        
        return view('umkms.payment', [
            'transaction' => $transaction,
            'package' => $transaction->package,
            'user' => Auth::user(),
            'expiryTime' => $expiryTime
        ]);
    }

    public function completePayment(Transaction $transaction)
    {
        // Pastikan transaksi milik user yang login
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Perbarui status transaksi
        $transaction->update(['status' => 'completed']);

        // Buat langganan baru
        $startDate = now();
        $endDate = now()->addDays($transaction->package->duration_days);

        Subscription::create([
            'user_id' => Auth::id(),
            'package_id' => $transaction->package_id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active'
        ]);

        return redirect()->route('premium.index')->with('success', 'Pembayaran berhasil! Langganan premium Anda telah diaktifkan.');
    }
}