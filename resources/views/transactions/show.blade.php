<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Struk Pembayaran</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Struk Pembayaran</h3>
                <div class="mt-4 space-y-3">
                    <p><strong>ID Transaksi:</strong> {{ $transaction->transaction_id }}</p>
                    <p><strong>Nama Paket:</strong> {{ $transaction->package->name }}</p>
                    <p><strong>Harga:</strong> Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                    <p><strong>Status:</strong> <span class="bg-green-100 text-green-800 px-2 py-1 rounded">Dibayar</span></p>
                    <p><strong>Tanggal:</strong> {{ $transaction->paid_at->format('d M Y') }}</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('transactions.pdf', $transaction) }}" class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
                <a href="{{ route('transactions.excel', $transaction) }}" class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    <i class="fas fa-file-excel"></i> Excel
                </a>
                <a href="{{ route('user.packages.index') }}" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</x-app-layout>