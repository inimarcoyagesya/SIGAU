<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-white">
            <i class="fas fa-map-marked-alt mr-2"></i>Dashboard SIGAU
        </h2>
    </x-slot>

    @push('styles')
    <!-- Leaflet CSS -->
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-sA+e2Nb4OyL0vEazj+1dQwY17oyF0Ynw+3UksdO+v3s="
        crossorigin="" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.fullscreen/2.4.0/Control.FullScreen.min.css"
        integrity="sha512-..."
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <style>
        #map {
            height: 400px;
            transition: all 0.3s ease;
        }

        .leaflet-container {
            border-radius: .75rem;
            overflow: hidden;
        }

        .no-data {
            @apply bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-300 p-6 rounded-lg text-center;
        }

        .leaflet-control-fullscreen {
            background-image: url("data:image/svg+xml;base64,PHN2ZyB4b...");
            background-size: 18px;
            background-position: center;
            @apply bg-white dark:bg-gray-700 rounded-sm shadow-md;
        }

        .leaflet-control-fullscreen.leaflet-fullscreen-on {
            background-image: url("data:image/svg+xml;base64,PHN2ZyB4b...");
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
                <!-- Terverifikasi -->
                <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-lg hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-300">UMKM Terverifikasi</p>
                            <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $verifiedUmkm ?? 0 }}</p>
                        </div>
                        <i class="fas fa-check-circle text-3xl text-green-500"></i>
                    </div>
                </div>
                <!-- Kategori -->
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

            <!-- Map & Recent UMKM -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Peta Sebaran UMKM -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">
                        <i class="fas fa-map-location-dot mr-2"></i>Peta Sebaran UMKM
                    </h3>
                    <div id="map">
                        @if($umkmLocations->isEmpty())
                        <div class="no-data">
                            <i class="fas fa-map-marker-slash text-2xl mb-2"></i>
                            <p>Tidak ada data lokasi UMKM</p>
                        </div>
                        @endif
                    </div>
                </div>
                <!-- UMKM Terbaru -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
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
                                @forelse($recentUmkms as $u)
                                <tr class="border-t border-gray-200 dark:border-gray-700">
                                    <td class="py-3">{{ $u->nama_usaha }}</td>
                                    <td>{{ $u->category->name ?? '—' }}</td>
                                    <td>{{ Str::limit($u->alamat, 40, '...') }}</td>
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
                <!-- Distribusi Kategori -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">
                        <i class="fas fa-chart-pie mr-2"></i>Distribusi Kategori
                    </h3>
                    @if(!$hasCategoryData)
                    <div class="no-data mt-4">
                        <i class="fas fa-chart-pie text-2xl mb-2"></i>
                        <p>Tidak ada data kategori</p>
                    </div>
                    @else
                    {!! $chart->container() !!}
                    @endif
                </div>
                <!-- Statistik Pendaftaran -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">
                        <i class="fas fa-chart-line mr-2"></i>Statistik Pendaftaran
                    </h3>
                    @if($registrationTrends->isEmpty())
                    <div class="no-data mt-4">
                        <i class="fas fa-chart-line text-2xl mb-2"></i>
                        <p>Tidak ada data pendaftaran</p>
                    </div>
                    @else
                    <div class="relative w-full h-48">
                        <canvas id="registrationChart" class="absolute inset-0 w-full h-full"></canvas>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <!-- Leaflet JS & Fullscreen -->
    <script
        src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-o9N1jG+gKFIlw4MqY+MUj6Rqd4hkH+4H7Eae4Mq4UIM="
        crossorigin=""></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.fullscreen/2.4.0/Control.FullScreen.min.js"
        integrity="sha512-..."
        crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>

    <!-- ApexCharts for pie (Larapex) -->
    @if($hasCategoryData)
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    {!! $chart->script() !!}
    @endif

    <!-- Chart.js for registration trends -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi peta
            const map = L.map('map').setView([-6.2088, 106.8456], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);
            L.control.fullscreen({
                position: 'topleft'
            }).addTo(map);

            // Ambil data lokasi UMKM sebagai array JS
            const umkmData = @json($mappedLocations);
            const markers = [];
            umkmData.forEach(u => {
                if (u.lat !== null && u.lng !== null) {
                    markers.push(
                        L.marker([u.lat, u.lng])
                        .addTo(map)
                        .bindPopup(`<strong>${u.nama}</strong><br>${u.kategori}`)
                    );
                }
            });

            if (markers.length) {
                const group = L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.2));
            }

            // Chart.js pendaftaran
            @if(!$registrationTrends->isEmpty())
            const ctx = document.getElementById('registrationChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($registrationTrends->keys()),
                    datasets: [{
                        label: 'Pendaftaran UMKM',
                        data: @json($registrationTrends->values()),
                        borderColor: '#3B82F6',
                        backgroundColor: 'rgba(59,130,246,0.1)',
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            ticks: {
                                color: getComputedStyle(document.body).color
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: getComputedStyle(document.body).color
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: getComputedStyle(document.body).color
                            }
                        }
                    }
                }
            });
            @endif
        });
    </script>
    @endpush

</x-app-layout>