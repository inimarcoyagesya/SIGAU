<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update UMKM') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('umkms.update', $umkm->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nama Usaha -->
                        <div class="mb-6">
                            <x-input-label for="nama_usaha" :value="__('Nama Usaha')" />
                            <x-text-input 
                                id="nama_usaha" 
                                name="nama_usaha" 
                                type="text" 
                                class="mt-1 block w-full" 
                                :value="old('nama_usaha', $umkm->nama_usaha)" 
                                required 
                                autofocus 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_usaha')" />
                        </div>

                        <!-- Kategori -->
                        <div class="mb-6">
                            <x-input-label for="category_id" :value="__('Kategori')" />
                            <select 
                                id="category_id" 
                                name="category_id" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                required
                            >
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $umkm->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                        </div>

                        <!-- Alamat -->
                        <div class="mb-6">
                            <x-input-label for="alamat" :value="__('Alamat')" />
                            <textarea 
                                id="alamat" 
                                name="alamat" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                required
                            >{{ old('alamat', $umkm->alamat) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
                        </div>

                        <!-- Latitude dan Longitude -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <x-input-label for="latitude" :value="__('Latitude')" />
                                <x-text-input 
                                    id="latitude" 
                                    name="latitude" 
                                    type="text" 
                                    class="mt-1 block w-full" 
                                    :value="old('latitude', $umkm->latitude)" 
                                    required 
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('latitude')" />
                            </div>
                            <div>
                                <x-input-label for="longitude" :value="__('Longitude')" />
                                <x-text-input 
                                    id="longitude" 
                                    name="longitude" 
                                    type="text" 
                                    class="mt-1 block w-full" 
                                    :value="old('longitude', $umkm->longitude)" 
                                    required 
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('longitude')" />
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-6">
                            <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                            <textarea 
                                id="deskripsi" 
                                name="deskripsi" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                required
                            >{{ old('deskripsi', $umkm->deskripsi) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('deskripsi')" />
                        </div>

                        <!-- Jam Operasional -->
                        <div class="mb-6">
                            <x-input-label for="jam_operasional" :value="__('Jam Operasional')" />
                            <x-text-input 
                                id="jam_operasional" 
                                name="jam_operasional" 
                                type="text" 
                                class="mt-1 block w-full" 
                                :value="old('jam_operasional', $umkm->jam_operasional)" 
                                required 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('jam_operasional')" />
                        </div>

                        <!-- Kontak -->
                        <div class="mb-6">
                            <x-input-label for="kontak" :value="__('Kontak')" />
                            <x-text-input 
                                id="kontak" 
                                name="kontak" 
                                type="text" 
                                class="mt-1 block w-full" 
                                :value="old('kontak', $umkm->kontak)" 
                                required 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('kontak')" />
                        </div>

                        <!-- Foto Usaha -->
                        <div class="mb-6">
                            <x-input-label for="foto_usaha" :value="__('Foto Usaha')" />
                            <input 
                                id="foto_usaha" 
                                name="foto_usaha" 
                                type="file" 
                                class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                accept="image/*"
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('foto_usaha')" />
                            @if($umkm->foto_usaha)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $umkm->foto_usaha) }}" alt="Foto Usaha" class="w-32 h-32 object-cover rounded-lg">
                                </div>
                            @endif
                        </div>

                        <!-- Status Verifikasi -->
                        <div class="mb-6">
                            <x-input-label for="status_verifikasi" :value="__('Status Verifikasi')" />
                            <select 
                                id="status_verifikasi" 
                                name="status_verifikasi" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                required
                            >
                                <option value="pending" {{ $umkm->status_verifikasi == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="terverifikasi" {{ $umkm->status_verifikasi == 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                                <option value="ditolak" {{ $umkm->status_verifikasi == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status_verifikasi')" />
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <x-danger-link-button :href="route('umkms.index')">
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