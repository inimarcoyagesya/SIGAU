<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            {{ __('Tambah UMKM') }}
        </h2>
    </x-slot>

    @push('styles')
    <style>
        /* Styling control geocoder */
        .leaflet-control-geocoder .leaflet-bar {
            background: #ffffff;
            opacity: 0.9 !important;
            border-radius: 4px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);
        }

        .leaflet-control-geocoder-form {
            background: #ffffff;
            padding: 6px;
            border-radius: 4px;
            box-shadow: none;
        }

        .leaflet-control-geocoder-form input {
            width: 180px;
        }
    </style>
    @endpush

    <form method="POST" action="{{ route('umkms.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Nama Usaha --}}
        <div class="mb-6">
            <x-input-label for="nama_usaha" :value="__('Nama Usaha')" />
            <x-text-input id="nama_usaha" name="nama_usaha" type="text"
                class="mt-1 block w-full" :value="old('nama_usaha')" required autofocus />
            <x-input-error :messages="$errors->get('nama_usaha')" class="mt-2" />
        </div>

        {{-- Kategori --}}
        <div class="mb-6">
            <x-input-label for="category_id" :value="__('Kategori')" />
            <select id="category_id" name="category_id"
                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200"
                required>
                <option value="">{{ __('Pilih Kategori') }}</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id')==$cat->id?'selected':'' }}>
                    {{ $cat->name }}
                </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
        </div>

        {{-- Alamat --}}
        <div class="mb-6">
            <x-input-label for="alamat" :value="__('Alamat')" />
            <textarea id="alamat" name="alamat" rows="3"
                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200"
                required>{{ old('alamat') }}</textarea>
            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
        </div>

        <div class="mb-6">
            <x-input-label :value="__('Cari Daerah')" />
            <div class="flex gap-2">
                <input
                    type="text"
                    id="search-input"
                    placeholder="Ketik nama daerah atau alamat…"
                    class="block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 px-3 py-2" />
                <button
                    type="button"
                    id="search-btn"
                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Cari
                </button>
            </div>
        </div>

        {{-- Map Picker --}}
        <div class="mb-6">
            <x-input-label :value="__('Lokasi UMKM')" />
            <div id="map" class="w-full h-64 rounded border"></div>

            <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                <strong>{{ __('Koordinat Terpilih:') }}</strong>
                <span id="coords-display">–</span>
            </div>

            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
            <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
            <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
        </div>

        {{-- Deskripsi --}}
        <div class="mb-6">
            <x-input-label for="deskripsi" :value="__('Deskripsi')" />
            <textarea id="deskripsi" name="deskripsi" rows="4"
                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200"
                required>{{ old('deskripsi') }}</textarea>
            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
        </div>

        {{-- Jam Operasional --}}
        <div class="mb-6">
            <x-input-label for="jam_operasional" :value="__('Jam Operasional')" />
            <x-text-input id="jam_operasional" name="jam_operasional" type="text"
                class="mt-1 block w-full" :value="old('jam_operasional')" required />
            <x-input-error :messages="$errors->get('jam_operasional')" class="mt-2" />
        </div>

        {{-- Kontak --}}
        <div class="mb-6">
            <x-input-label for="kontak" :value="__('Kontak')" />
            <x-text-input id="kontak" name="kontak" type="text"
                class="mt-1 block w-full" :value="old('kontak')" required />
            <x-input-error :messages="$errors->get('kontak')" class="mt-2" />
        </div>

        {{-- Foto Usaha --}}
        <div class="mb-6">
            <x-input-label for="foto_usaha" :value="__('Foto Usaha')" />
            <input id="foto_usaha" name="foto_usaha" type="file"
                class="mt-1 block w-full text-sm border-gray-300 rounded cursor-pointer"
                accept="image/*" />
            <x-input-error :messages="$errors->get('foto_usaha')" class="mt-2" />
        </div>

        {{-- Status --}}
        <div class="mb-6">
            <x-input-label for="status" :value="__('Status Verifikasi')" />
            <select id="status" name="status"
                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200"
                required>
                <option value="pending" {{ old('status')=='pending'?'selected':'' }}>Pending</option>
                <option value="terverifikasi" {{ old('status')=='terverifikasi'?'selected':'' }}>Terverifikasi</option>
                <option value="ditolak" {{ old('status')=='ditolak'?'selected':'' }}>Ditolak</option>
            </select>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>

        {{-- Buttons --}}
        <div class="flex justify-end gap-4">
            <x-danger-link-button :href="route('umkms.index')">{{ __('Batal') }}</x-danger-link-button>
            <x-primary-button>{{ __('Tambah UMKM') }}</x-primary-button>
        </div>
    </form>

    @push('scripts')
    <script src="https://unpkg.com/leaflet-control-geocoder@1.13.0/dist/Control.Geocoder.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi peta
            const map = L.map('map').setView([-6.200000, 106.816666], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Marker klik & search
            let clickMarker = null,
                searchMarker = null;

            function updateCoords(lat, lng) {
                document.getElementById('latitude').value = lat.toFixed(6);
                document.getElementById('longitude').value = lng.toFixed(6);
                document.getElementById('coords-display').textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
            }

            // Marker via klik
            map.on('click', e => {
                if (clickMarker) map.removeLayer(clickMarker);
                clickMarker = L.marker(e.latlng).addTo(map);
                updateCoords(e.latlng.lat, e.latlng.lng);
            });

            // Setup geocoder service (Nominatim)
            const geocoderService = L.Control.Geocoder.nominatim();

            // Event tombol cari
            document.getElementById('search-btn').addEventListener('click', () => {
                const query = document.getElementById('search-input').value.trim();
                if (!query) return alert('Masukkan kata kunci pencarian.');

                geocoderService.geocode(query, results => {
                    if (!results || results.length === 0) {
                        return alert('Lokasi tidak ditemukan.');
                    }
                    const center = results[0].center;

                    // Hapus marker search sebelumnya
                    if (searchMarker) map.removeLayer(searchMarker);

                    // Tambah marker baru & buka popup nama place
                    searchMarker = L.marker(center).addTo(map)
                        .bindPopup(results[0].name || query)
                        .openPopup();

                    map.setView(center, 15);
                    updateCoords(center.lat, center.lng);
                });
            });
        });
    </script>
    @endpush

</x-app-layout>