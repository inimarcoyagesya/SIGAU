<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice Transaksi</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script> 
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        @page {
            margin: 1cm;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body class="bg-white text-gray-800">
    <!-- Invoice Header -->
    <div class="max-w-4xl mx-auto bg-white p-6 border-b border-gray-300">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-blue-600">SIGAU</h1>
                <p class="text-sm text-gray-600">Jl. Raya GIS No. 123</p>
                <p class="text-sm text-gray-600">Jakarta, Indonesia</p>
            </div>
            <div class="text-right">
                <h2 class="text-xl font-semibold text-gray-900">Invoice</h2>
                <p class="text-gray-500">#{{ $transactions->first()->transaction_id }}</p>
                <p class="text-gray-500 text-sm">Tanggal: {{ now()->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>

    <!-- User Info -->
    <div class="max-w-4xl mx-auto bg-white p-6 border-b border-gray-300">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <h3 class="font-semibold text-gray-700 mb-2">Kepada:</h3>
                <p class="text-gray-600">{{ $transactions->first()->user_id }}</p>
            </div>
            <div class="text-right">
                <h3 class="font-semibold text-gray-700 mb-2">Tanggal Laporan</h3>
                <p class="text-gray-600">Dari: {{ $transactions->min('created_at')->format('d/m/Y') }}</p>
                <p class="text-gray-600">Sampai: {{ $transactions->max('created_at')->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Transaction Table -->
    <div class="max-w-4xl mx-auto bg-white p-6">
        <table class="w-full border-collapse text-sm text-left">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 font-medium text-gray-700">ID</th>
                    <th class="px-4 py-2 font-medium text-gray-700">Paket</th>
                    <th class="px-4 py-2 font-medium text-gray-700">Durasi</th>
                    <th class="px-4 py-2 font-medium text-gray-700 text-right">Harga</th>
                    <th class="px-4 py-2 font-medium text-gray-700">Status</th>
                    <th class="px-4 py-2 font-medium text-gray-700">Tanggal Bayar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($transactions as $t)
                <tr class="hover:bg-blue-50 transition-colors">
                    <td class="px-4 py-2">{{ $t->transaction_id }}</td>
                    <td class="px-4 py-2 font-medium">{{ $t->package->name }}</td>
                    <td class="px-4 py-2">{{ $t->package->duration }} Bulan</td>
                    <td class="px-4 py-2 text-right">Rp {{ number_format($t->amount, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">
                        <span class="
                            inline-block px-2 py-1 rounded-full text-xs font-semibold
                            @if($t->status === 'success') 
                                bg-green-100 text-green-800 
                            @elseif($t->status === 'pending')
                                bg-yellow-100 text-yellow-800
                            @else
                                bg-red-100 text-red-800
                            @endif
                        ">{{ $t->status }}</span>
                    </td>
                    <td class="px-4 py-2">
                        @if($t->paid_at)
                            {{ $t->paid_at->format('d/m/Y') }}
                        @else
                            <span class="text-gray-400">Belum Dibayar</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50">
                <tr>
                    <td colspan="3" class="px-4 py-2 font-medium text-gray-700">Total Transaksi</td>
                    <td class="px-4 py-2 font-semibold text-right text-lg text-gray-900">
                        Rp {{ number_format($transactions->sum('amount'), 0, ',', '.') }}
                    </td>
                    <td colspan="2" class="px-4 py-2"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Footer -->
    <div class="max-w-4xl mx-auto bg-white p-6 mt-8 border-t border-gray-300 text-center">
        <p class="text-gray-600 text-sm">Terima kasih telah menggunakan layanan kami!</p>
        <p class="text-gray-500 text-xs mt-1">Halaman ini dihasilkan secara otomatis. Harap tidak mengubah isi dokumen.</p>
    </div>
</body>
</html>