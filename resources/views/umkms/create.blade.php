<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
            <i class="fas fa-map-marked-alt mr-2"></i>Tambah UMKM
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
      <!-- Geocoder CSS -->
      <link 
        rel="stylesheet" 
        href="https://unpkg.com/leaflet-control-geocoder@1.13.0/dist/Control.Geocoder.css"
      />
      <style>
        /* Styling geocoder control */
        .leaflet-control-geocoder .leaflet-bar {
          background: #fff; opacity: .9; border-radius: 4px; box-shadow: 0 1px 4px rgba(0,0,0,.3);
        }
        #map { height: 300px; border-radius: .5rem; }
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

      {{-- Map Picker --}}
      <div class="mb-6">
        <x-input-label :value="__('Lokasi UMKM')" />
        <div id="map" class="mt-2"></div>
        <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">
          <strong>{{ __('Koordinat Terpilih:') }}</strong>
          <span id="coords-display">–</span>
        </div>
        <input type="hidden" id="latitude"  name="latitude"  value="{{ old('latitude') }}" required>
        <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}" required>
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
          <option value="active" {{ old('status')=='active'?'selected':'' }}>active</option>
          <option value="banned" {{ old('status')=='banned'?'selected':'' }}>banned</option>
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
      <!-- Leaflet JS -->
      <script 
        src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256‑o9N1jG+gKFIlw4MqY+MUj6Rqd4hkH+4H7Eae4Mq4UIM="
        crossorigin=""
      ></script>
      <!-- Geocoder JS -->
      <script 
        src="https://unpkg.com/leaflet-control-geocoder@1.13.0/dist/Control.Geocoder.js"
      ></script>

      <script>
        document.addEventListener('DOMContentLoaded', function() {
          // Default Jakarta kalau belum ada old()
          const initLat = parseFloat("{{ old('latitude', -6.200000) }}");
          const initLng = parseFloat("{{ old('longitude', 106.816666) }}");

          const map = L.map('map').setView([initLat, initLng], 13);
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
          }).addTo(map);

          // Marker draggable
          let marker = L.marker([initLat, initLng], { draggable: true }).addTo(map);
          marker.on('moveend', e => {
            const { lat, lng } = e.target.getLatLng();
            updateCoords(lat, lng);
          });

          // Klik peta untuk pindah marker
          map.on('click', e => {
            marker.setLatLng(e.latlng);
            updateCoords(e.latlng.lat, e.latlng.lng);
          });

          // Control geocoder di pojok kanan atas
          L.Control.geocoder({
            position: 'topright',
            placeholder: 'Cari alamat…',
            defaultMarkGeocode: false
          })
          .on('markgeocode', function(e) {
            const c = e.geocode.center;
            map.setView(c, 15);
            marker.setLatLng(c);
            updateCoords(c.lat, c.lng);
          })
          .addTo(map);

          function updateCoords(lat, lng) {
            document.getElementById('latitude').value = lat.toFixed(6);
            document.getElementById('longitude').value = lng.toFixed(6);
            document.getElementById('coords-display').textContent =
              lat.toFixed(6) + ', ' + lng.toFixed(6);
          }
        });
      </script>
    @endpush

</x-app-layout>
