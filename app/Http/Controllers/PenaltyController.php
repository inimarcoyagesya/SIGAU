<?php

namespace App\Http\Controllers;

use App\Models\PenaltyPayment;   // ⇽ buat model sederhana PenaltyPayment
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PenaltyController extends Controller
{
    /**
     * Seluruh endpoint di-protect Breeze (auth & verified email).
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * GET /penalty
     * ­Tampilkan halaman “Pembayaran Denda”.
     */
    public function index()
    {
        $user = Auth::user();

        // Nominal denda bisa Anda pindahkan ke config/penalty.php jika ingin fleksibel.
        $amount = 200_000;
        $banReason = $user->ban_reason ?? null;     // kolom di tabel users

        return view('penalty.index', [
            'amount'    => $amount,
            'banReason' => $banReason,
        ]);
    }

    /**
     * POST /penalty
     * ­Terima & simpan bukti pembayaran.
     */
    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => ['required', 'in:bank_transfer,ewallet'],
            'ewallet_type'   => ['required_if:payment_method,ewallet', 'nullable', 'in:gopay,ovo,dana,shopeepay'],
            'payment_proof'  => ['required_if:payment_method,bank_transfer', 'image', 'max:2048'],
        ]);

        $user = $request->user();
        $proofPath = null;

        if ($request->hasFile('payment_proof')) {
            // simpan bukti transfer, public disk → storage/app/public/payment-proofs
            $proofPath = $request->file('payment_proof')
                                 ->store('payment-proofs', 'public');
        }

        /** @var \App\Models\PenaltyPayment $payment */
        $payment = PenaltyPayment::create([
            'user_id'      => $user->id,
            'amount'       => 200_000,
            'method'       => $request->payment_method,
            'ewallet_type' => $request->ewallet_type,
            'proof_path'   => $proofPath,
            'status'       => $request->payment_method === 'bank_transfer'
                                ? 'pending_manual'     // admin perlu cek bukti
                                : 'pending_auto',       // e-wallet auto-verify
        ]);

        // TODO: Kirim notifikasi ke admin / queue proses verifikasi otomatis

        return back()->with('status', 'Bukti pembayaran berhasil dikirim. Kami akan memverifikasi dalam 1×24 jam.');
    }

    /**
     * PUT /penalty/{payment}/verify
     * ­Dipanggil admin setelah pengecekan: set status “paid” + buka blokir.
     */
    public function verify(PenaltyPayment $payment)
    {
        // Pastikan route ini diproteksi middleware admin / can:verify-payment
        $payment->update([
            'status'   => 'paid',
            'paid_at'  => now(),
        ]);

        // Unban user
        $user = $payment->user;
        $user->update([
            'is_banned'  => false,
            'ban_reason' => null,
        ]);

        return back()->with('status', 'Pembayaran diverifikasi & akun berhasil diaktifkan.');
    }
}
