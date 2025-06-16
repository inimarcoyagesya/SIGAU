<!-- resources/views/user/transactions/payment.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-6">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-xl font-semibold">Pembayaran Berhasil</h3>
                <p class="mt-4">Terima kasih telah berlangganan!</p>
                <a href="{{ route('transactions.show', $transaction) }}" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Lihat Struk
                </a>
            </div>
        </div>
    </div>
</x-app-layout>