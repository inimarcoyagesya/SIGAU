<!-- resources/views/user/transactions/invoice.blade.php -->
<table>
    <tr><th>ID Transaksi</th><td>{{ $transaction->transaction_id }}</td></tr>
    <tr><th>Nama Paket</th><td>{{ $transaction->package->name }}</td></tr>
    <tr><th>Harga</th><td>Rp {{ number_format($transaction->amount, 2) }}</td></tr>
    <tr><th>Tanggal</th><td>{{ $transaction->paid_at->format('d/m/Y') }}</td></tr>
</table>