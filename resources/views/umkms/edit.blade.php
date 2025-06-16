<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update UMKM') }}
        </h2>
    </x-slot>

    @push('styles')
      <!-- Leaflet CSS -->
      <link 
        rel="stylesheet" 
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
        integrity="sha256‑sA+e2Nb4OyL0vEazj+1dQwY17oyF0Ynw+3UksdO+v3s=" 
        crossorigin=""
      />
      <!-- Geocoder CSS (opsional) -->
      <link 
        rel="stylesheet" 
        href="https://unpkg.com/leaflet-control-geocoder@1.13.0/dist/Control.Geocoder.css" 
      />
      <style>
        #map { height: 300px; border-radius: .5rem; }
      </style>
    @endpush

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

                        {{-- Map Picker --}}
                        <div class="mb-6">
                            <x-input-label :value="__('Lokasi UMKM')" />
                            <div id="map" class="mt-2"></div>
                            <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                            <strong>Koordinat terpilih:</strong>
                            <span id="coords-display">{{ old('latitude', $umkm->latitude) }}, {{ old('longitude', $umkm->longitude) }}</span>
                            </div>
                            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $umkm->latitude) }}">
                            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $umkm->longitude) }}">
                            <x-input-error class="mt-2" :messages="$errors->get('latitude')" />
                            <x-input-error class="mt-2" :messages="$errors->get('longitude')" />
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
                                <option value="active" {{ $umkm->status_verifikasi == 'active' ? 'selected' : '' }}>active</option>
                                <option value="banned" {{ $umkm->status_verifikasi == 'banned' ? 'selected' : '' }}>banned</option>
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
    @push('scripts')
      <!-- Leaflet JS -->
      <script 
        src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" 
        integrity="sha256‑o9N1jG+gKFIlw4MqY+MUj6Rqd4hkH+4H7Eae4Mq4UIM=" 
        crossorigin=""
      ></script>
      <!-- Geocoder JS (opsional) -->
      <script src="https://unpkg.com/leaflet-control-geocoder@1.13.0/dist/Control.Geocoder.js"></script>

      <script>
        document.addEventListener('DOMContentLoaded', function () {
          // Baca initial coords (atau default Jakarta)
          const initLat = parseFloat("{{ old('latitude', $umkm->latitude ?? -6.200000) }}");
          const initLng = parseFloat("{{ old('longitude', $umkm->longitude ?? 106.816666) }}");

          // Inisialisasi peta
          const map = L.map('map').setView([initLat, initLng], 13);
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
          }).addTo(map);

          // Marker existing
          let marker = L.marker([initLat, initLng], { draggable: true }).addTo(map);
          // Jika marker dipindah via drag
          marker.on('moveend', function(e) {
            const { lat, lng } = e.target.getLatLng();
            updateCoords(lat, lng);
          });

          // Klik untuk pasang marker baru
          map.on('click', function(e) {
            const { lat, lng } = e.latlng;
            marker.setLatLng(e.latlng);
            updateCoords(lat, lng);
          });

          // Geocoder (search)
          const geocoder = L.Control.geocoder({
            defaultMarkGeocode: false,
            placeholder: 'Cari…'
          })
          .on('markgeocode', function(e) {
            const c = e.geocode.center;
            map.setView(c, 15);
            marker.setLatLng(c);
            updateCoords(c.lat, c.lng);
          })
          .addTo(map);

          // Integrasi search-input manual
          document.getElementById('search-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
              e.preventDefault();
              geocoder.options.geocoder.geocode(this.value, results => {
                if (results.length) geocoder.fire('markgeocode', { geocode: results[0] });
              });
            }
          });

          // Fungsi update hidden+display
          function updateCoords(lat, lng) {
            document.getElementById('latitude').value = lat.toFixed(6);
            document.getElementById('longitude').value = lng.toFixed(6);
            document.getElementById('coords-display').textContent = lat.toFixed(6) + ', ' + lng.toFixed(6);
          }
        });
      </script>
    @endpush
</x-app-layout>