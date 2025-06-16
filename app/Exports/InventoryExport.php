<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventoryExport implements FromCollection, WithHeadings
{
    protected $ids;

    public function __construct(array $ids = [])
    {
        $this->ids = $ids;
    }

    /**
     * Ambil collection yang akan diexport.
     * Jika ada $ids, filter berdasarkan ID; kalau tidak, ambil semua.
     */
    public function collection()
    {
        $query = Inventory::with('umkm')->select([
            'id','nama_produk','harga','stok','supplier','expired_date'
        ]);

        if (!empty($this->ids)) {
            $query->whereIn('id', $this->ids);
        }

        return $query->get()->map(function($inv) {
            return [
                $inv->id,
                $inv->nama_produk,
                $inv->umkm->nama_usaha ?? '-',
                $inv->harga,
                $inv->stok,
                $inv->supplier,
                $inv->expired_date,
            ];
        });
    }

    /**
     * Header kolom Excel.
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama Produk',
            'UMKM',
            'Harga',
            'Stok',
            'Supplier',
            'Expired Date',
        ];
    }
}
