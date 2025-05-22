<!DOCTYPE html>
<html>
<head>
    <title>Laporan Inventori</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .title { font-size: 20px; font-weight: bold; }
        .subtitle { font-size: 16px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f8f9fa; }
        .text-right { text-align: right; }
        .footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; }
        .stok-low { color: #dc3545; }
        .stok-ok { color: #28a745; }
    </style>
</head>
<body>
    <div class="header">
    <h2 style="text-align: center;">
    @if(isset($title))
        {{ $title }}
    @else
        Laporan Inventori UMKM
    @endif
</h2>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>UMKM</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Supplier</th>
                <th>Expired Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventories as $key => $inventory)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $inventory->nama_produk }}</td>
                <td>{{ $inventory->umkm->nama_usaha ?? 'N/A' }}</td>
                <td class="text-right">Rp {{ number_format($inventory->harga, 0, ',', '.') }}</td>
                <td>
                    <span class="{{ $inventory->stok < 10 ? 'stok-low' : 'stok-ok' }}">
                        {{ $inventory->stok }}
                    </span>
                </td>
                <td>{{ $inventory->supplier ?? '-' }}</td>
                <td>{{ $inventory->expired_date ? \Carbon\Carbon::parse($inventory->expired_date)->format('d/m/Y') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right"><strong>Total:</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($totalNilai, 0, ',', '.') }}</strong></td>
                <td><strong>{{ $totalStok }}</strong></td>
                <td colspan="2"></td>
            </tr>
            <p style="text-align: center;">
                Jumlah Item Terpilih: {{ count($inventories) }}
            </p>
        </tfoot>
    </table>

    <div class="footer">
        <div>Dicetak pada: {{ date('d/m/Y H:i') }}</div>
        <div>Halaman: <span class="pageNumber"></span></div>
    </div>
</body>
</html>