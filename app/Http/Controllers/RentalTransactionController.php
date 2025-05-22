<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\RentalTransaction;
use App\Models\TransactionDetail;
use App\Models\UMKM;
use App\Models\User;
use App\Models\RentalItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RentalTransactionController extends Controller
{
    // Menampilkan daftar transaksi
    public function index()
    {
        $transactions = RentalTransaction::with(['user', 'umkm', 'transactionDetails'])
            ->latest()
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    // Menampilkan form create transaksi baru
    public function create()
    {
        $users = User::all();
        $umkms = UMKM::all();
        $inventories = Inventory::where('stok', '>', 0)->get();

        return view('transactions.create', compact('users', 'umkms', 'inventories'));
    }

    // Menyimpan transaksi baru
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            // Validasi data
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'umkm_id' => 'required|exists:umkms,id',
                'transaction_date' => 'required|date',
                'status' => 'required|in:Pending,Paid,Completed,Cancelled',
                'details' => 'required|array|min:1',
                'details.*.inventory_id' => 'required|exists:inventories,id',
                'details.*.quantity' => 'required|integer|min:1',
                'details.*.rental_start' => 'required|date',
                'details.*.rental_end' => 'required|date|after:details.*.rental_start',
                'details.*.sub_total' => 'required|numeric|min:0',
            ]);

            // Create transaction
            $transaction = RentalTransaction::create([
                'user_id' => $validated['user_id'],
                'umkm_id' => $validated['umkm_id'],
                'transaction_date' => $validated['transaction_date'],
                'status' => $validated['status'],
                'total_amount' => 0, // Temporary value, will be updated
            ]);

            // Create transaction details
            foreach ($validated['details'] as $detail) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'inventory_id' => $detail['inventory_id'],
                    'quantity' => $detail['quantity'],
                    'rental_start' => $detail['rental_start'],
                    'rental_end' => $detail['rental_end'],
                    'sub_total' => $detail['sub_total'],
                ]);

                // Update availability status jika diperlukan
                // Inventory::where('id', $detail['inventory_id'])->update(['availability_status' => false]);
            }

            // Calculate total
            $transaction->calculateTotal();
        });

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction created successfully');
    }

    // Menampilkan detail transaksi
    public function show(RentalTransaction $transaction)
    {
        $transaction->load([
            'user', 
            'umkm', 
            'transactionDetails.rentalItem', 
            'payment'
        ]);

        return view('transactions.show', compact('transaction'));
    }

    // Menampilkan form edit transaksi
    public function edit(RentalTransaction $transaction)
    {
        $users = User::all();
        $umkms = UMKM::with('rentalItems')->get();
        $rentalItems = Inventory::where('stok', true)->get();
        $transaction->load('transactionDetails');

        return view('transactions.edit', compact(
            'transaction', 
            'users', 
            'umkms', 
            'rentalItems'
        ));
    }

    // Update transaksi
    public function update(Request $request, RentalTransaction $transaction)
    {
        DB::transaction(function () use ($request, $transaction) {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'umkm_id' => 'required|exists:umkms,id',
                'transaction_date' => 'required|date',
                'status' => 'required|in:Pending,Paid,Completed,Cancelled',
                'details' => 'required|array|min:1',
                'details.*.id' => 'sometimes|exists:transaction_details,id',
                'details.*.inventory_id' => 'required|exists:inventories,id',
                'details.*.quantity' => 'required|integer|min:1',
                'details.*.rental_start' => 'required|date',
                'details.*.rental_end' => 'required|date|after:details.*.rental_start',
                'details.*.sub_total' => 'required|numeric|min:0',
            ]);

            // Update transaction
            $transaction->update([
                'user_id' => $validated['user_id'],
                'umkm_id' => $validated['umkm_id'],
                'transaction_date' => $validated['transaction_date'],
                'status' => $validated['status'],
            ]);

            // Update or create details
            $existingDetails = $transaction->transactionDetails->keyBy('id');

            foreach ($validated['details'] as $detailData) {
                if (isset($detailData['id']) && $existingDetails->has($detailData['id'])) {
                    // Update existing detail
                    $detail = $existingDetails->get($detailData['id']);
                    $detail->update($detailData);
                    $existingDetails->forget($detailData['id']);
                } else {
                    // Create new detail
                    TransactionDetail::create(array_merge(
                        $detailData, 
                        ['transaction_id' => $transaction->id]
                    ));
                }
            }

            // Delete removed details
            foreach ($existingDetails as $detail) {
                $detail->delete();
            }

            // Recalculate total
            $transaction->calculateTotal();
        });

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction updated successfully');
    }

    // Hapus transaksi
    public function destroy(RentalTransaction $transaction)
    {
        DB::transaction(function () use ($transaction) {
            $transaction->transactionDetails()->delete();
            $transaction->payment()->delete();
            $transaction->delete();
        });

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully');
    }

    // API untuk mendapatkan item rental berdasarkan UMKM
    public function getInventories(UMKM $umkm)
    {
        $inventories = $umkm->inventories()
            ->where('stok', '>', 0)
            ->get();

        return response()->json($inventories);
    }
}