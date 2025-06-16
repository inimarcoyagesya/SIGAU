<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Transaction') }}
        </h2>
    </x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">

                <form action="{{ route('umkm.transactions.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="mb-4">
                                <label for="nama_transaksi" class="block text-gray-700 text-sm font-bold mb-2">Nama Transaksi *</label>
                                <input type="text" name="nama_transaksi" id="nama_transaksi" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh: Pembayaran Konsultan Pajak" required>
                                @error('nama_transaksi')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="jumlah" class="block text-gray-700 text-sm font-bold mb-2">Jumlah (Rp) *</label>
                                <input type="number" name="jumlah" id="jumlah" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" min="0" step="1000" placeholder="0" required>
                                @error('jumlah')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Transaksi *</label>
                                <div class="mt-2 space-y-2">
                                    <div class="flex items-center">
                                        <input id="jenis_pemasukan" name="jenis" type="radio" value="pemasukan" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500" checked>
                                        <label for="jenis_pemasukan" class="ml-3 block text-sm font-medium text-gray-700">Pemasukan</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="jenis_pengeluaran" name="jenis" type="radio" value="pengeluaran" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                        <label for="jenis_pengeluaran" class="ml-3 block text-sm font-medium text-gray-700">Pengeluaran</label>
                                    </div>
                                </div>
                                @error('jenis')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="keterangan" class="block text-gray-700 text-sm font-bold mb-2">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Deskripsi transaksi..."></textarea>
                                @error('keterangan')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex items-center justify-end">
                        <a href="{{ route('umkm.transactions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-3">
                            Batal
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</x-app-layout>