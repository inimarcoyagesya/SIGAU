<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Package;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $packages = Package::where('status', 'Aktif')->get();
    return view('admin.transactions.index', compact('packages'));
}

public function report(Request $request)
{
    $request->validate([
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date'
    ]);

    $transactions = Transaction::with(['package', 'user'])
        ->whereBetween('created_at', [$request->start_date, $request->end_date])
        ->get();

    return response()->json($transactions);
}

public function pdfReport(Request $request)
{
    $transactions = Transaction::with(['package', 'user'])
        ->whereBetween('created_at', [$request->start_date, $request->end_date])
        ->get();

    $pdf = Pdf::loadView('admin.reports.transactions', compact('transactions'));
    return $pdf->download('transaksi-'.$request->start_date.'-'.$request->end_date.'.pdf');
}

public function excelReport(Request $request)
{
    $request->validate([
        'start_date' => 'required|date',
        'end_date' => 'required|after_or_equal:start_date'
    ]);

    $transactions = Transaction::with(['package', 'user'])
        ->whereBetween('created_at', [$request->start_date, $request->end_date])
        ->get();

    return Excel::download(
        new TransactionExport($transactions),
        "transaksi_{$request->start_date}_to_{$request->end_date}.xlsx"
    );
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $users = User::all();
    $packages = Package::where('status', 'Aktif')->get();
    return view('admin.transactions.create', compact('users', 'packages'));
}

public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'package_id' => 'required|exists:packages,id',
        'amount' => 'required|numeric',
        'status' => 'in:pending,success,failed',
        'paid_at' => 'nullable|date',
    ]);

    try {
        $transaction = Transaction::create([
            'user_id' => $request->user_id,
            'package_id' => $request->package_id,
            'transaction_id' => 'TRX-' . strtoupper(Str::random(8)),
            'amount' => $request->amount,
            'status' => $request->status ?? 'pending',
            'paid_at' => $request->paid_at,
        ]);

        return redirect()->route('admin.transactions.index')
            ->with('success', "Transaksi berhasil dibuat untuk paket $transaction->package_id");
    } catch (\Throwable $th) {
        return back()->with('error', $th->getMessage());
    }
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
