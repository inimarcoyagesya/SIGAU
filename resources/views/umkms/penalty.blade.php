{{-- resources/views/umkm/penalty.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-white">
            <i class="fas fa-exclamation-triangle mr-2"></i>Pembayaran Denda
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <div class="flex items-start mb-6">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500 text-3xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Pembayaran Denda Akun Diblokir
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 mt-2">
                            Akun UMKM Anda saat ini diblokir karena: 
                            <span class="font-medium">{{ $ban_reason ?? 'pelanggaran ketentuan platform' }}</span>
                        </p>
                    </div>
                </div>

                <div class="bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800 rounded-xl p-6 mb-6">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-red-600 dark:text-red-400">
                            Rp {{ number_format($penalty_fee, 0, ',', '.') }}
                        </p>
                        <p class="text-gray-600 dark:text-gray-300 mt-2">
                            Total denda yang harus dibayarkan
                        </p>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        Metode Pembayaran
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 flex items-center cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                            <i class="fab fa-bca text-blue-600 text-2xl mr-3"></i>
                            <div>
                                <p class="font-medium">Bank BCA</p>
                                <p class="text-sm text-gray-500">Transfer Bank</p>
                            </div>
                        </div>
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 flex items-center cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                            <i class="fab fa-gopay text-green-500 text-2xl mr-3"></i>
                            <div>
                                <p class="font-medium">Gopay</p>
                                <p class="text-sm text-gray-500">E-Wallet</p>
                            </div>
                        </div>
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 flex items-center cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                            <i class="fab fa-cc-visa text-yellow-500 text-2xl mr-3"></i>
                            <div>
                                <p class="font-medium">Kartu Kredit</p>
                                <p class="text-sm text-gray-500">Visa/Mastercard</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('umkm.penalty.payment') }}">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Pilih Metode Pembayaran
                        </label>
                        <select class="form-input w-full rounded-lg p-3" name="payment_method" required>
                            <option value="">Pilih metode pembayaran</option>
                            <option value="bca">Bank BCA</option>
                            <option value="gopay">Gopay</option>
                            <option value="credit_card">Kartu Kredit</option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn-primary px-6 py-3 text-white rounded-lg font-medium">
                            <i class="fas fa-credit-card mr-2"></i> Bayar Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>