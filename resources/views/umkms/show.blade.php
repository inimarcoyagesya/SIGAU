<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight flex items-center">
            <i class="fas fa-store mr-2 text-indigo-500"></i> {{ __('UMKM Detail') }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto mt-10 bg-gradient-to-r from-white via-gray-100 to-white dark:from-gray-800 dark:via-gray-900 dark:to-gray-800 shadow-xl rounded-xl overflow-hidden">
        <!-- Header -->
        <div class="flex items-center p-8 bg-indigo-100 dark:bg-indigo-900">
            <img src="{{ $umkm->foto_usaha ? asset('storage/' . $umkm->foto_usaha) : asset('default-image.jpg') }}" 
                 alt="Foto Usaha" 
                 class="w-32 h-32 rounded-full object-cover border-4 border-indigo-500 shadow-lg mr-8">
            <div>
                <h2 class="text-3xl font-bold mb-2 text-gray-800 dark:text-gray-200">{{ $umkm->nama_usaha }}</h2>
                <p class="text-indigo-700 dark:text-indigo-300 font-medium mb-1">
                    <i class="fas fa-tags mr-1"></i> Kategori: {{ $umkm->category->name }}
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Status: 
                    @if ($umkm->status == 'pending')
                        <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded">{{ ucfirst($umkm->status) }}</span>
                    @elseif ($umkm->status == 'terverifikasi')
                        <span class="bg-green-200 text-green-800 px-2 py-1 rounded">{{ ucfirst($umkm->status) }}</span>
                    @else
                        <span class="bg-red-200 text-red-800 px-2 py-1 rounded">{{ ucfirst($umkm->status) }}</span>
                    @endif
                </p>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-300 dark:border-gray-700 my-4 mx-8"></div>

        <!-- Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8 divide-y md:divide-y-0 md:divide-x divide-gray-300 dark:divide-gray-700">
            <!-- Informasi Usaha -->
            <div class="space-y-4 pr-4">
                <h3 class="text-xl font-semibold text-indigo-700 dark:text-indigo-300 mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i> Informasi Usaha
                </h3>
                <p><strong>📍 Alamat:</strong> <span class="text-gray-700 dark:text-gray-300">{{ $umkm->alamat }}</span></p>
                <p><strong>📞 Kontak:</strong> <span class="text-gray-700 dark:text-gray-300">{{ $umkm->kontak }}</span></p>
                <p><strong>⏰ Jam Operasional:</strong> <span class="text-gray-700 dark:text-gray-300">{{ $umkm->jam_operasional }}</span></p>
                <p><strong>📝 Deskripsi:</strong> <span class="text-gray-700 dark:text-gray-300">{{ $umkm->deskripsi }}</span></p>
            </div>

            <!-- Lokasi -->
            <div class="space-y-4 pl-4 pt-8 md:pt-0">
                <h3 class="text-xl font-semibold text-indigo-700 dark:text-indigo-300 mb-4 flex items-center">
                    <i class="fas fa-map-marker-alt mr-2"></i> Lokasi
                </h3>
                <p><strong>Latitude:</strong> <span class="text-gray-700 dark:text-gray-300">{{ $umkm->latitude }}</span></p>
                <p><strong>Longitude:</strong> <span class="text-gray-700 dark:text-gray-300">{{ $umkm->longitude }}</span></p>

                <div class="mt-4 border rounded-lg overflow-hidden shadow-md">
                    <iframe 
                        src="https://www.google.com/maps?q={{ $umkm->latitude }},{{ $umkm->longitude }}&hl=es;z=14&output=embed"
                        width="100%" height="250" allowfullscreen loading="lazy" 
                        class="border-0"></iframe>
                </div>
            </div>
        </div>

        <!-- Divider bawah -->
        <div class="border-b border-gray-300 dark:border-gray-700 my-6"></div>

        <!-- Footer -->
        <div class="p-8 flex justify-end bg-gray-100 dark:bg-gray-800">
        <a href="{{ route('umkms.index') }}" class="inline-block bg-indigo-600 text-dark px-4 py-2 rounded-lg shadow-md hover:bg-indigo-700 transition-colors duration-300">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
    </a>
        </div>
    </div>
</x-app-layout>
