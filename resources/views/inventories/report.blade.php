{{-- resources/views/inventories/report.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ $title ?? 'Laporan Inventori' }}</title>
  <style>
    body { font-family: sans-serif; font-size: 12px; }
    h1 { text-align: center; margin-bottom: 1rem; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 1rem; }
    th, td { border: 1px solid #333; padding: 6px; }
    th { background: #eee; }
    .text-right { text-align: right; }
    tfoot td { font-weight: bold; }
  </style>
</head>
<body>
  <h1>{{ $title }}</h1>

  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Nama Produk</th>
        <th>UMKM</th>
        <th class="text-right">Stok</th>
        <th class="text-right">Harga</th>
        <th class="text-right">Nilai</th>
      </tr>
    </thead>
    <tbody>
      @foreach($inventories as $idx => $inv)
      <tr>
        <td>{{ $idx + 1 }}</td>
        <td>{{ $inv->nama_produk }}</td>
        <td>{{ $inv->umkm->nama_usaha ?? '-' }}</td>
        <td class="text-right">{{ $inv->stok }}</td>
        <td class="text-right">{{ number_format($inv->harga,0,',','.') }}</td>
        <td class="text-right">{{ number_format($inv->harga * $inv->stok,0,',','.') }}</td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <td colspan="3"></td>
        <td class="text-right">{{ $totalStok }}</td>
        <td></td>
        <td class="text-right">{{ number_format($totalNilai,0,',','.') }}</td>
      </tr>
    </tfoot>
  </table>

  <p>Dicetak: {{ now()->format('d-m-Y H:i') }}</p>
</body>
</html>
