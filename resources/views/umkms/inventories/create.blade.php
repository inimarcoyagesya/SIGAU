<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Inventory') }}
        </h2>
    </x-slot>
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">

                <form action="{{ route('umkm.inventories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="nama_produk" class="block text-gray-700 text-sm font-bold mb-2">Nama Produk *</label>
                        <input type="text" name="nama_produk" id="nama_produk" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        @error('nama_produk')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                        @error('deskripsi')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="stok" class="block text-gray-700 text-sm font-bold mb-2">Stok *</label>
                            <input type="number" name="stok" id="stok" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" min="0" required>
                            @error('stok')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="satuan" class="block text-gray-700 text-sm font-bold mb-2">Satuan *</label>
                            <select name="satuan" id="satuan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="pcs">Pcs</option>
                                <option value="kg">Kg</option>
                                <option value="gram">Gram</option>
                                <option value="liter">Liter</option>
                                <option value="pack">Pack</option>
                                <option value="dus">Dus</option>
                            </select>
                            @error('satuan')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="harga" class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp) *</label>
                            <input type="number" name="harga" id="harga" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" min="0" required>
                            @error('harga')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="expired_date" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Kadaluarsa</label>
                            <input type="date" name="expired_date" id="expired_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('expired_date')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="gambar" class="block text-gray-700 text-sm font-bold mb-2">Gambar Produk</label>
                        <input type="file" name="gambar" id="gambar" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('gambar')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mt-6 flex items-center justify-end">
                        <a href="{{ route('umkm.inventories.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-3">
                            Batal
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Simpan Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</x-app-layout>