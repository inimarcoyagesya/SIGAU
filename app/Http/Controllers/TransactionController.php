<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionExport;

class TransactionController extends Controller
{
    // Menampilkan form pembayaran (opsional)
    public function create(Package $package)
    {
        return view('transactions.payment', compact('package'));
    }

    // Proses konfirmasi pembelian
    public function confirm(Request $request,Package $package)
    {

        // Simulasi pembayaran berhasil
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'package_id' => $package->id,
            'transaction_id' => 'TRX-' . strtoupper(Str::random(8)),
            'amount' => $package->price,
            'status' => 'success',
            'paid_at' => now()
        ]);

        return redirect()->route('transactions.show', $transaction);
    }

    // Menampilkan detail transaksi
    public function show(Transaction $transaction)
    {
        // Pastikan user hanya bisa mengakses transaksinya sendiri
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('transactions.show', compact('transaction'));
    }

    // Generate laporan PDF
    public function pdf(Transaction $transaction)
    {
        $pdf = Pdf::loadView('transactions.invoice', compact('transaction'));
        return $pdf->download("invoice-{$transaction->transaction_id}.pdf");
    }

    // Generate laporan Excel
    public function excel(Transaction $transaction)
    {
        return Excel::download(
            new TransactionExport($transaction), 
            "invoice-{$transaction->transaction_id}.xlsx"
        );
    }

    // Riwayat transaksi di admin
    public function index()
    {
        $transactions = Transaction::with(['package', 'user'])->latest()->get();
        return view('admin.transactions.index', compact('transactions'));
    }
}