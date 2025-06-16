<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard UMKM - SIGAU</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .gis-gradient {
            background: linear-gradient(135deg, #3B82F6 0%, #10B981 100%);
        }
        .map-pattern {
            background-image: radial-gradient(rgba(59, 130, 246, 0.1) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        .hover-scale {
            transition: transform 0.2s ease-in-out;
        }
        .hover-scale:hover {
            transform: translateY(-3px);
        }
        .minimalist-bg {
            background-color: #f8fafc;
            background-image: 
                linear-gradient(rgba(59, 130, 246, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59, 130, 246, 0.05) 1px, transparent 1px),
                linear-gradient(rgba(59, 130, 246, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59, 130, 246, 0.03) 1px, transparent 1px);
            background-size: 
                50px 50px,
                50px 50px,
                10px 10px,
                10px 10px;
            background-position: 
                -1px -1px,
                -1px -1px,
                -1px -1px,
                -1px -1px;
        }

        .dark .minimalist-bg {
            background-color: #0f172a;
            background-image: 
                linear-gradient(rgba(99, 102, 241, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99, 102, 241, 0.05) 1px, transparent 1px),
                linear-gradient(rgba(99, 102, 241, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99, 102, 241, 0.03) 1px, transparent 1px);
        }
        
        #umkm-map {
            height: 400px;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
        }
        
        .status-active {
            background-color: #10B98120;
            color: #10B981;
        }
        
        .status-banned {
            background-color: #EF444420;
            color: #EF4444;
        }
        
        .quick-action-card {
            transition: all 0.3s ease;
            border: 1px solid #E5E7EB;
            border-radius: 16px;
            overflow: hidden;
        }
        
        .quick-action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen minimalist-bg dark:bg-gray-900">
        <!-- Navigation -->
        <nav class="w-full gis-gradient shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <a href="{{ route('umkm.dashboard') }}" class="flex items-center space-x-2">
                        <i class="fas fa-map-marker-alt text-white text-2xl"></i>
                        <span class="text-white font-bold text-xl">SIGAU</span>
                        <span class="text-sm text-white/80 ml-2">Dashboard UMKM</span>
                    </a>

                    <div class="flex space-x-4 items-center">
                        <div class="flex items-center space-x-2">
                            <div class="status-badge @if(auth()->user()->status === 'active') status-active @else status-banned @endif">
                                <i class="fas fa-circle mr-1"></i>
                                {{ auth()->user()->status === 'active' ? 'Aktif' : 'Diblokir' }}
                            </div>
                        </div>
                        
                        <!-- User Dropdown -->
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm text-white focus:outline-none">
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    <i class="fas fa-user-circle mr-2"></i> Profil Saya
                                </x-dropdown-link>
                                
                                <x-dropdown-link :href="route('umkm.profile')">
                                    <i class="fas fa-store mr-2"></i> Profil UMKM
                                </x-dropdown-link>
                                
                                <x-dropdown-link :href="route('umkm.transactions.index')">
                                    <i class="fas fa-receipt mr-2"></i> Transaksi
                                </x-dropdown-link>
                                
                                <div class="border-t border-gray-200 dark:border-gray-600"></div>
                                
                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Dashboard UMKM
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    Kelola usaha Anda dan pantau perkembangan melalui dashboard ini
                </p>
            </div>
            
            <!-- Status Warning -->
            @if(auth()->user()->status === 'banned')
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-900 rounded-xl p-6 mb-8">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-red-800 dark:text-red-200">
                            Akun Anda Saat Ini Diblokir
                        </h3>
                        <div class="mt-2 text-red-700 dark:text-red-300">
                            <p>
                                Status akun UMKM Anda saat ini <span class="font-bold">diblokir</span> karena 
                                @if(auth()->user()->ban_reason)
                                    {{ auth()->user()->ban_reason }}
                                @else
                                    pelanggaran ketentuan platform
                                @endif
                            </p>
                            <p class="mt-2">
                                Untuk mengaktifkan kembali akun Anda, silakan lakukan pembayaran denda sebesar 
                                <span class="font-bold">Rp {{ number_format(auth()->user()->penalty_fee, 0, ',', '.') }}</span>
                            </p>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('umkm.penalty.payment') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none transition">
                                Bayar Denda Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Stats & Map -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                            <div class="flex items-center">
                                <div class="p-3 rounded-lg bg-blue-100 dark:bg-blue-900/30">
                                    <i class="fas fa-eye text-blue-600 dark:text-blue-400 text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                        Pengunjung
                                    </p>
                                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                                        1.2K
                                    </p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="text-xs text-green-600 dark:text-green-400 font-medium">
                                    <i class="fas fa-arrow-up mr-1"></i> 12.3%
                                </p>
                            </div>
                        </div>
                        
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                            <div class="flex items-center">
                                <div class="p-3 rounded-lg bg-green-100 dark:bg-green-900/30">
                                    <i class="fas fa-cart-shopping text-green-600 dark:text-green-400 text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                        Penjualan
                                    </p>
                                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                                        48
                                    </p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="text-xs text-green-600 dark:text-green-400 font-medium">
                                    <i class="fas fa-arrow-up mr-1"></i> 5.2%
                                </p>
                            </div>
                        </div>
                        
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                            <div class="flex items-center">
                                <div class="p-3 rounded-lg bg-amber-100 dark:bg-amber-900/30">
                                    <i class="fas fa-star text-amber-600 dark:text-amber-400 text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                        Rating
                                    </p>
                                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                                        4.7
                                    </p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="text-xs text-green-600 dark:text-green-400 font-medium">
                                    <i class="fas fa-arrow-up mr-1"></i> 0.3%
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Map -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Lokasi UMKM & Kompetitor Terdekat
                            </h3>
                            <div class="flex space-x-2">
                                <button class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                    <i class="fas fa-sync-alt mr-1"></i> Refresh
                                </button>
                            </div>
                        </div>
                        
                        <div id="umkm-map"></div>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="space-y-8">
                    <!-- Quick Actions -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            Akses Cepat
                        </h3>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('umkm.profile') }}" class="quick-action-card">
                                <div class="p-5 bg-blue-50 dark:bg-blue-900/20">
                                    <div class="text-center mb-2">
                                        <i class="fas fa-store text-blue-600 dark:text-blue-400 text-2xl"></i>
                                    </div>
                                    <p class="text-center text-sm font-medium text-gray-900 dark:text-white">
                                        Profil UMKM
                                    </p>
                                </div>
                            </a>
                            
                            <a href="{{ route('umkm.inventories.index') }}" class="quick-action-card">
                                <div class="p-5 bg-green-50 dark:bg-green-900/20">
                                    <div class="text-center mb-2">
                                        <i class="fas fa-boxes-stacked text-green-600 dark:text-green-400 text-2xl"></i>
                                    </div>
                                    <p class="text-center text-sm font-medium text-gray-900 dark:text-white">
                                        Kelola Stok
                                    </p>
                                </div>
                            </a>
                            
                            <a href="{{ route('umkm.promotion.show', ['id' => $umkm->id]) }}" class="quick-action-card">
                                <div class="p-5 bg-amber-50 dark:bg-amber-900/20">
                                    <div class="text-center mb-2">
                                        <i class="fas fa-bullhorn text-amber-600 dark:text-amber-400 text-2xl"></i>
                                    </div>
                                    <p class="text-center text-sm font-medium text-gray-900 dark:text-white">
                                        Buat Promosi
                                    </p>
                                </div>
                            </a>
                            
                            <a href="{{ route('umkm.transactions.index') }}" class="quick-action-card">
                                <div class="p-5 bg-purple-50 dark:bg-purple-900/20">
                                    <div class="text-center mb-2">
                                        <i class="fas fa-receipt text-purple-600 dark:text-purple-400 text-2xl"></i>
                                    </div>
                                    <p class="text-center text-sm font-medium text-gray-900 dark:text-white">
                                        Transaksi
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Competitors -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            Kompetitor Terdekat
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-store text-gray-600"></i>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        Toko Kerajinan Jaya
                                    </p>
                                    <div class="flex items-center mt-1">
                                        <div class="flex text-amber-400">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">4.5</span>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        <i class="fas fa-location-dot mr-1"></i> 1.2 km dari lokasi Anda
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-store text-gray-600"></i>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        Warung Makan Sederhana
                                    </p>
                                    <div class="flex items-center mt-1">
                                        <div class="flex text-amber-400">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">4.0</span>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        <i class="fas fa-location-dot mr-1"></i> 0.8 km dari lokasi Anda
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-store text-gray-600"></i>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        Bengkel Motor Sejahtera
                                    </p>
                                    <div class="flex items-center mt-1">
                                        <div class="flex text-amber-400">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">5.0</span>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        <i class="fas fa-location-dot mr-1"></i> 2.1 km dari lokasi Anda
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <a href="#" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                Lihat Semua Kompetitor
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        // Initialize the map
        function initMap() {
            // Default location (using user's location if available)
            const defaultLat = -7.7956;
            const defaultLng = 110.3695;
            
            // Create map
            const map = L.map('umkm-map').setView([defaultLat, defaultLng], 13);
            
            // Add tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            
            // Add user's UMKM marker
            const userMarker = L.marker([defaultLat, defaultLng]).addTo(map)
                .bindPopup('<b>Lokasi UMKM Anda</b><br>Nama UMKM Anda')
                .openPopup();
                
            // Add competitor markers (simulated data)
            const competitors = [
                {name: 'Toko Kerajinan Jaya', lat: -7.8000, lng: 110.3700, category: 'Kerajinan'},
                {name: 'Warung Makan Sederhana', lat: -7.7900, lng: 110.3650, category: 'Kuliner'},
                {name: 'Bengkel Motor Sejahtera', lat: -7.7850, lng: 110.3750, category: 'Jasa'},
                {name: 'Butik Fashion Modern', lat: -7.7950, lng: 110.3800, category: 'Fashion'},
            ];
            
            competitors.forEach(competitor => {
                L.marker([competitor.lat, competitor.lng]).addTo(map)
                    .bindPopup(`<b>${competitor.name}</b><br>Kategori: ${competitor.category}`);
            });
        }
        
        // Initialize map when page loads
        document.addEventListener('DOMContentLoaded', initMap);
    </script>
</body>
</html>