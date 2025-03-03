<!-- resources/views/umkm/register.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-white">
            <i class="fas fa-user-plus mr-2"></i>Pendaftaran UMKM
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
                <form method="POST" action="{{ route('umkm.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Section 1: Informasi Dasar -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                        <h3 class="text-xl font-semibold mb-4 text-blue-600 dark:text-blue-400">
                            <i class="fas fa-info-circle mr-2"></i>Informasi Dasar UMKM
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama UMKM -->
                            <div>
                                <x-input-label value="Nama Usaha" class="text-gray-600 dark:text-gray-300" />
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-store text-gray-400"></i>
                                    </div>
                                    <x-text-input 
                                        type="text" 
                                        name="nama_usaha" 
                                        class="pl-10 w-full"
                                        placeholder="Masukkan nama usaha"
                                        required
                                    />
                                </div>
                                <x-input-error :messages="$errors->get('nama_usaha')" class="mt-2" />
                            </div>

                            <!-- Kategori -->
                            <div>
                                <x-input-label value="Kategori UMKM" class="text-gray-600 dark:text-gray-300" />
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-tag text-gray-400"></i>
                                    </div>
                                    <select name="category_id" class="pl-10 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>

                            <!-- Deskripsi -->
                            <div class="md:col-span-2">
                                <x-input-label value="Deskripsi Usaha" class="text-gray-600 dark:text-gray-300" />
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 pt-3 flex items-start pointer-events-none">
                                        <i class="fas fa-align-left text-gray-400"></i>
                                    </div>
                                    <textarea 
                                        name="deskripsi" 
                                        rows="4"
                                        class="pl-10 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm"
                                        placeholder="Deskripsikan usaha Anda secara detail"
                                        required
                                    ></textarea>
                                </div>
                                <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Lokasi & Kontak -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                        <h3 class="text-xl font-semibold mb-4 text-green-600 dark:text-green-400">
                            <i class="fas fa-map-marker-alt mr-2"></i>Lokasi & Kontak
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Alamat -->
                            <div class="md:col-span-2">
                                <x-input-label value="Alamat Lengkap" class="text-gray-600 dark:text-gray-300" />
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-map-pin text-gray-400"></i>
                                    </div>
                                    <x-text-input 
                                        type="text" 
                                        name="alamat" 
                                        class="pl-10 w-full"
                                        placeholder="Masukkan alamat lengkap"
                                        required
                                    />
                                </div>
                                <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                            </div>

                            <!-- Koordinat -->
                            <div>
                                <x-input-label value="Latitude" class="text-gray-600 dark:text-gray-300" />
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-globe-asia text-gray-400"></i>
                                    </div>
                                    <x-text-input 
                                        type="number" 
                                        step="any"
                                        name="latitude" 
                                        class="pl-10 w-full"
                                        placeholder="Koordinat latitude"
                                        required
                                    />
                                </div>
                                <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label value="Longitude" class="text-gray-600 dark:text-gray-300" />
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-globe-asia text-gray-400"></i>
                                    </div>
                                    <x-text-input 
                                        type="number" 
                                        step="any"
                                        name="longitude" 
                                        class="pl-10 w-full"
                                        placeholder="Koordinat longitude"
                                        required
                                    />
                                </div>
                                <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
                            </div>

                            <!-- Kontak -->
                            <div>
                                <x-input-label value="Kontak" class="text-gray-600 dark:text-gray-300" />
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-phone-alt text-gray-400"></i>
                                    </div>
                                    <x-text-input 
                                        type="text" 
                                        name="kontak" 
                                        class="pl-10 w-full"
                                        placeholder="Nomor telepon/WhatsApp"
                                        required
                                    />
                                </div>
                                <x-input-error :messages="$errors->get('kontak')" class="mt-2" />
                            </div>

                            <!-- Jam Operasional -->
                            <div>
                                <x-input-label value="Jam Operasional" class="text-gray-600 dark:text-gray-300" />
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-clock text-gray-400"></i>
                                    </div>
                                    <x-text-input 
                                        type="text" 
                                        name="jam_operasional" 
                                        class="pl-10 w-full"
                                        placeholder="Contoh: 08:00 - 17:00"
                                        required
                                    />
                                </div>
                                <x-input-error :messages="$errors->get('jam_operasional')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Upload Foto -->
                    <div>
                        <h3 class="text-xl font-semibold mb-4 text-purple-600 dark:text-purple-400">
                            <i class="fas fa-camera-retro mr-2"></i>Foto Usaha
                        </h3>
                        
                        <div class="mt-1 flex justify-center rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 px-6 pt-5 pb-6">
                            <div class="space-y-1 text-center">
                                <div class="flex items-center justify-center text-gray-400">
                                    <i class="fas fa-cloud-upload-alt text-3xl"></i>
                                </div>
                                <div class="flex text-sm text-gray-600 dark:text-gray-300">
                                    <label class="relative cursor-pointer rounded-md bg-white dark:bg-gray-800 font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                        <span>Upload file</span>
                                        <input 
                                            type="file" 
                                            name="foto_usaha" 
                                            class="sr-only"
                                            accept="image/*"
                                            onchange="previewImage(event)"
                                        >
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    PNG, JPG, JPEG (Maks. 2MB)
                                </p>
                                <img id="imagePreview" class="mt-4 mx-auto max-h-48 hidden rounded-lg">
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('foto_usaha')" class="mt-2" />
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-paper-plane mr-2"></i>Daftarkan UMKM
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewImage(event) {
            const preview = document.getElementById('imagePreview');
            const file = event.target.files[0];
            
            if (file) {
                preview.classList.remove('hidden');
                preview.src = URL.createObjectURL(file);
            } else {
                preview.classList.add('hidden');
                preview.src = '';
            }
        }
    </script>
    @endpush
</x-app-layout>