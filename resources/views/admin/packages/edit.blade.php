<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update Paket Langganan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.packages.update', $package->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Nama Paket -->
                        <div class="mb-6">
                            <x-input-label for="name" :value="__('Nama Paket')" />
                            <x-text-input 
                                id="name" 
                                name="name" 
                                type="text" 
                                class="mt-1 block w-full" 
                                :value="old('name', $package->name)" 
                                required 
                                autofocus 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-6">
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea 
                                id="description" 
                                name="description" 
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                rows="4"
                            >{{ old('description', $package->description) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <!-- Harga -->
                        <div class="mb-6">
                            <x-input-label for="price" :value="__('Harga (Rp)')" />
                            <x-text-input 
                                id="price" 
                                name="price" 
                                type="number" 
                                class="mt-1 block w-full" 
                                :value="old('price', $package->price)" 
                                required 
                                min="0"
                                placeholder="Contoh: 299000"
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('price')" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Masukkan harga tanpa titik/koma (contoh: 299000)</p>
                        </div>

                        <!-- Durasi -->
                        <div class="mb-6">
                            <x-input-label for="duration" :value="__('Durasi (Bulan)')" />
                            <select 
                                id="duration" 
                                name="duration" 
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required
                            >
                                @foreach([1, 3, 6, 12] as $bulan)
                                    <option value="{{ $bulan }}" 
                                        {{ old('duration', $package->duration) == $bulan ? 'selected' : '' }}>
                                        {{ $bulan }} Bulan
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('duration')" />
                        </div>

                        <!-- Status -->
                        <div class="mb-6">
                            <x-input-label for="status" :value="__('Status')" />
                            <select 
                                id="status" 
                                name="status" 
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required
                            >
                                <option value="Aktif" {{ old('status', $package->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Nonaktif" {{ old('status', $package->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <x-danger-link-button :href="route('admin.packages.index')">
                                {{ __('Batal') }}
                            </x-danger-link-button>
                            
                            <x-primary-button>
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>