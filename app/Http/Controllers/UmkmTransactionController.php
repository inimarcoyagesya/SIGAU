<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UmkmTransactionController extends Controller
{
    public function index()
    {
        $umkm = Umkm::where('user_id', Auth::id())->firstOrFail();
        $transactions = $umkm->transactions()->latest()->paginate(10);

        return view('umkms.transactions.index', compact('transactions', 'umkm'));
    }

    public function create()
    {
        return view('umkms.transactions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_transaksi' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
        ]);

        $umkm = Umkm::where('user_id', Auth::id())->firstOrFail();

        $umkm->transactions()->create([
            'nama_transaksi' => $request->nama_transaksi,
            'jumlah' => $request->jumlah,
            'status' => 'pending',
        ]);

        return redirect()->route('umkm.transactions.index')->with('success', 'Transaksi berhasil dibuat.');
    }

    public function show(Transaction $transaction)
    {
        $this->authorizeAccess($transaction);
        return view('umkms.transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $this->authorizeAccess($transaction);
        return view('umkms.transactions.edit', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->authorizeAccess($transaction);

        $request->validate([
            'nama_transaksi' => 'required|string',
            'jumlah' => 'required|numeric',
            'status' => 'required|in:pending,success,failed',
        ]);

        $transaction->update($request->only('nama_transaksi', 'jumlah', 'status'));

        return redirect()->route('umkm.transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorizeAccess($transaction);
        $transaction->delete();

        return redirect()->route('umkm.transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    private function authorizeAccess(Transaction $transaction)
    {
        $umkm = Umkm::where('user_id', Auth::id())->firstOrFail();
        abort_if($transaction->umkm_id !== $umkm->id, 403);
    }
}

