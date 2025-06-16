<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionExport implements FromCollection, WithHeadings, WithMapping
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return ['ID Transaksi', 'Paket', 'Harga', 'Tanggal'];
    }

    public function map($row): array
    {
        return [
            $row->transaction_id,
            $row->package->name,
            'Rp ' . number_format($row->amount, 0, ',', '.'),
            $row->paid_at->format('d/m/Y'),
        ];
    }
}