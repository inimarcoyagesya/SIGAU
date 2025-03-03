<!-- resources/views/dashboard.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-white">
            <i class="fas fa-map-marked-alt mr-2"></i>Dashboard SIGAU
        </h2>
    </x-slot>

    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.fullscreen/2.4.0/Control.FullScreen.min.css" />
    <style>
        #map { 
            height: 400px;
            transition: all 0.3s ease;
        }
        .leaflet-container { 
            border-radius: 0.75rem;
            overflow: hidden;
        }
        .no-data { 
            @apply bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-300 p-6 rounded-lg text-center;
        }
        .leaflet-control-fullscreen {
            background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9ImN1cnJlbnRDb2xvciIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiPjxwYXRoIGQ9Ik04IDNINWEyIDIgMCAwIDAtMiAydjNtMTggMFY1YTIgMiAwIDAgMC0yLTJoLTNtMCAxOGgzYTIgMiAwIDAgMCAyLTJ2LTNNMyAxNnYzYTIgMiAwIDAgMCAyIDJoMyIvPjwvc3ZnPg==);
            background-size: 18px;
            background-position: center;
            @apply bg-white dark:bg-gray-700 rounded-sm shadow-md;
        }
        .leaflet-control-fullscreen.leaflet-fullscreen-on {
            background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9ImN1cnJlbnRDb2xvciIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiPjxwYXRoIGQ9Ik04IDN2M2EyIDIgMCAwIDEtMiAyaC0zbTAgMThoM2EyIDIgMCAwIDAgMi0ydjNtMTMtMThoLTNhMiAyIDAgMCAwLTIgMnYzbTMtM3YzYTIgMiAwIDAgMS0yIDJoLTMiLz48L3N2Zz4=);
        }
    </style>
    @endpush

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total UMKM -->
                <div class="bg-gradient-to-r from-blue-600 to-green-600 text-white p-6 rounded-xl shadow-lg hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm">Total UMKM</p>
                            <p class="text-3xl font-bold">{{ $totalUmkm ?? 0 }}</p>
                        </div>
                        <i class="fas fa-store text-3xl opacity-75"></i>
                    </div>
                </div>

                <!-- UMKM Terverifikasi -->
                <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-lg hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-300">UMKM Terverifikasi</p>
                            <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $verifiedUmkm ?? 0 }}</p>
                        </div>
                        <i class="fas fa-check-circle text-3xl text-green-500"></i>
                    </div>
                </div>

                <!-- Kategori UMKM -->
                <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-lg hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Kategori UMKM</p>
                            <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $totalCategories ?? 0 }}</p>
                        </div>
                        <i class="fas fa-tags text-3xl text-blue-500"></i>
                    </div>
                </div>

                <!-- Pendaftar Baru -->
                <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-lg hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Pendaftar Baru</p>
                            <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $newRegistrations ?? 0 }}</p>
                        </div>
                        <i class="fas fa-user-plus text-3xl text-purple-500"></i>
                    </div>
                </div>
            </div>

            <!-- Map and Recent UMKM -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Map Section -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg mb-8">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">
                        <i class="fas fa-map-location-dot mr-2"></i>Peta Sebaran UMKM
                    </h3>
                    <div id="map" class="w-full h-96">
                        @if(empty($umkmLocations) || count($umkmLocations) === 0)
                            <div class="no-data">
                                <i class="fas fa-map-marker-slash text-2xl mb-2"></i>
                                <p>Tidak ada data lokasi UMKM</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent UMKM -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg mb-8">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">
                        <i class="fas fa-clock-rotate-left mr-2"></i>UMKM Terbaru
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="text-left text-gray-600 dark:text-gray-400">
                                <tr>
                                    <th class="pb-3">Nama UMKM</th>
                                    <th class="pb-3">Kategori</th>
                                    <th class="pb-3">Lokasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentUmkms as $umkm)
                                <tr class="border-t border-gray-200 dark:border-gray-700">
                                    <td class="py-3">{{ $umkm->nama_usaha ?? '-' }}</td>
                                    <td>{{ $umkm->category->name ?? 'Belum Terkategori' }}</td>
                                    <td>{{ $umkm->alamat ?? 'Lokasi Tidak Diketahui' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="py-4 text-center text-gray-500 dark:text-gray-400">
                                        Tidak ada data UMKM terbaru
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">
                        <i class="fas fa-chart-pie mr-2"></i>Distribusi Kategori
                    </h3>
                    <canvas id="categoryChart"></canvas>
                    @if(($categoryDistribution ?? collect())->isEmpty())
                        <div class="no-data mt-4">
                            <i class="fas fa-chart-pie text-2xl mb-2"></i>
                            <p>Tidak ada data kategori</p>
                        </div>
                    @endif
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">
                        <i class="fas fa-chart-line mr-2"></i>Statistik Pendaftaran
                    </h3>
                    <canvas id="registrationChart"></canvas>
                    @if(($registrationTrends ?? collect())->isEmpty())
                        <div class="no-data mt-4">
                            <i class="fas fa-chart-line text-2xl mb-2"></i>
                            <p>Tidak ada data pendaftaran</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.fullscreen/2.4.0/Control.FullScreen.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Peta
        const map = L.map('map').setView([-6.2088, 106.8456], 13);
        
        // Tambahkan Tile Layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Tambahkan Kontrol Fullscreen
        const fullscreenControl = L.control.fullscreen({
            position: 'topleft',
            title: 'Buka Layar Penuh',
            titleCancel: 'Keluar Layar Penuh',
            forceSeparateButton: true,
            forcePseudoFullscreen: true
        });
        map.addControl(fullscreenControl);

        // Tambahkan Marker UMKM
        const umkmLocations = json($umkmLocations);
        const markers = [];
        
        umkmLocations.forEach(umkm => {
            const marker = L.marker([umkm.latitude || 0, umkm.longitude || 0])
                .addTo(map)
                .bindPopup(`
                    <b class="font-semibold">${umkm.nama_usaha || 'Nama Tidak Tersedia'}</b><br>
                    <span class="text-sm">${umkm.alamat || ''}</span><br>
                    <span class="text-xs text-gray-500">Kategori: ${umkm.category ? umkm.category.name : 'Belum Terkategori'}
                `);
            markers.push(marker);
        });

        // Fit Bounds
        if(markers.length > 0) {
            const group = L.featureGroup(markers);
            map.fitBounds(group.getBounds().pad(0.2));
        }

        // Inisialisasi Chart.js
        const chartConfig = {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#374151'
                    }
                }
            }
        };

        // Chart Kategori
        const categoryCtx = document.getElementById('categoryChart');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: json($categoryDistribution->keys()),
                datasets: [{
                    data: json($categoryDistribution->values()),
                    backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6']
                }]
            },
            options: chartConfig
        });

        // Chart Pendaftaran
        const registrationCtx = document.getElementById('registrationChart');
        new Chart(registrationCtx, {
            type: 'line',
            data: {
                labels: json($registrationTrends->keys()),
                datasets: [{
                    label: 'Pendaftaran UMKM',
                    data: json($registrationTrends->values()),
                    borderColor: '#3B82F6',
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(59, 130, 246, 0.1)'
                }]
            },
            options: {
                ...chartConfig,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#374151'
                        }
                    },
                    x: {
                        ticks: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#374151'
                        }
                    }
                }
            }
        });
    });
    </script>
    @endpush
</x-app-layout>