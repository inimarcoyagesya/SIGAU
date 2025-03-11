<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Inventory') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('inventories.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- UMKM ID -->
                        <div class="mb-6">
                            <x-input-label for="umkm_id" :value="__('UMKM')" />
                            <select 
                                id="umkm_id" 
                                name="umkm_id" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                required
                            >
                                <option value="">Pilih UMKM</option>
                                @foreach($umkms as $umkm)
                                    <option value="{{ $umkm->id }}" {{ old('umkm_id') == $umkm->id ? 'selected' : '' }}>
                                        {{ $umkm->nama_usaha }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('umkm_id')" />
                        </div>

                        <!-- Nama Produk -->
                        <div class="mb-6">
                            <x-input-label for="nama_produk" :value="__('Nama Produk')" />
                            <x-text-input 
                                id="nama_produk" 
                                name="nama_produk" 
                                type="text" 
                                class="mt-1 block w-full" 
                                :value="old('nama_produk')" 
                                required 
                                autofocus 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_produk')" />
                        </div>

                        <!-- Harga -->
                        <div class="mb-6">
                            <x-input-label for="harga" :value="__('Harga')" />
                            <x-text-input 
                                id="harga" 
                                name="harga" 
                                type="number" 
                                class="mt-1 block w-full" 
                                :value="old('harga')" 
                                required 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('harga')" />
                        </div>

                        <!-- Stok -->
                        <div class="mb-6">
                            <x-input-label for="stok" :value="__('Stok')" />
                            <x-text-input 
                                id="stok" 
                                name="stok" 
                                type="number" 
                                class="mt-1 block w-full" 
                                :value="old('stok')" 
                                required 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('stok')" />
                        </div>

                        <!-- Supplier -->
                        <div class="mb-6">
                            <x-input-label for="supplier" :value="__('Supplier')" />
                            <x-text-input 
                                id="supplier" 
                                name="supplier" 
                                type="text" 
                                class="mt-1 block w-full" 
                                :value="old('supplier')" 
                                required 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('supplier')" />
                        </div>

                        <!-- Tanggal Kadaluarsa -->
                        <div class="mb-6">
                            <x-input-label for="expired_date" :value="__('Tanggal Kadaluarsa')" />
                            <x-text-input 
                                id="expired_date" 
                                name="expired_date" 
                                type="date" 
                                class="mt-1 block w-full" 
                                :value="old('expired_date')" 
                                required 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('expired_date')" />
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <x-danger-link-button :href="route('inventories.index')">
                                {{ __('Batal') }}
                            </x-danger-link-button>
                            
                            <x-primary-button>
                                {{ __('Tambah Inventory') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
