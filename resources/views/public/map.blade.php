<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Peta UMKM - SIGAU</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

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
        
        #public-map {
            height: 500px;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .umkm-card {
            transition: all 0.3s ease;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            overflow: hidden;
        }
        
        .umkm-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .umkm-category-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .category-kuliner {
            background-color: #FEF3C7;
            color: #92400E;
        }
        
        .category-kerajinan {
            background-color: #D1FAE5;
            color: #065F46;
        }
        
        .category-jasa {
            background-color: #DBEAFE;
            color: #1E40AF;
        }
        
        .category-fashion {
            background-color: #FCE7F3;
            color: #9D174D;
        }
        
        .search-container {
            position: relative;
            z-index: 1000;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen minimalist-bg dark:bg-gray-900">
        <!-- Navigation -->
        <nav class="w-full gis-gradient shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <a href="{{ route('welcome') }}" class="flex items-center space-x-2">
                        <i class="fas fa-map-marker-alt text-white text-2xl"></i>
                        <span class="text-white font-bold text-xl">SIGAU</span>
                    </a>

                    <div class="flex space-x-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-white hover:bg-blue-700/20 px-4 py-2 rounded-lg transition">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-white hover:bg-blue-700/20 px-4 py-2 rounded-lg transition">
                                Masuk
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-white hover:bg-green-700/20 px-4 py-2 rounded-lg transition">
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Search Section -->
            <div class="mb-8 p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg search-container">
                <div class="flex flex-col md:flex-row md:items-end space-y-4 md:space-y-0 md:space-x-6">
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Cari UMKM
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input 
                                type="text" 
                                id="search" 
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Nama usaha, produk, atau lokasi...">
                        </div>
                    </div>
                    
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Kategori
                        </label>
                        <select id="category" class="block w-full py-3 px-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Kategori</option>
                            <option value="kuliner">Kuliner</option>
                            <option value="kerajinan">Kerajinan</option>
                            <option value="jasa">Jasa</option>
                            <option value="fashion">Fashion</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="distance" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Jarak Maks
                        </label>
                        <select id="distance" class="block w-full py-3 px-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="5">5 km</option>
                            <option value="10" selected>10 km</option>
                            <option value="20">20 km</option>
                            <option value="50">50 km</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Rating Minimal
                        </label>
                        <select id="rating" class="block w-full py-3 px-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="0">Semua Rating</option>
                            <option value="3">3 bintang ke atas</option>
                            <option value="4" selected>4 bintang ke atas</option>
                            <option value="5">5 bintang</option>
                        </select>
                    </div>
                    
                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                    
                    <div>
                        <button type="button" class="gis-gradient hover:opacity-90 text-white px-6 py-3 rounded-lg font-medium">
                            <i class="fas fa-filter mr-2"></i> Terapkan Filter
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Map & Results -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Map -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                        <div id="public-map"></div>
                    </div>
                </div>
                
                <!-- Results -->
                <div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            Daftar UMKM Terdekat
                        </h3>
                        
                        <div class="space-y-4">
                            <!-- UMKM Card 1 -->
                            <div class="umkm-card bg-white dark:bg-gray-700">
                                <div class="p-5">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-bold text-gray-900 dark:text-white">Warung Makan Sederhana</h4>
                                            <div class="mt-1 flex items-center">
                                                <span class="umkm-category-badge category-kuliner">Kuliner</span>
                                                <div class="flex text-amber-400 ml-3">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star-half-alt"></i>
                                                    <span class="text-xs text-gray-500 dark:text-gray-300 ml-1">4.5</span>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="text-blue-600 dark:text-blue-400">
                                            <i class="fas fa-location-dot"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="mt-3 text-sm text-gray-600 dark:text-gray-300">
                                        <p class="flex items-center">
                                            <i class="fas fa-map-marker-alt mr-2"></i>
                                            Jl. Mawar No. 15, Yogyakarta
                                        </p>
                                        <p class="flex items-center mt-2">
                                            <i class="fas fa-phone mr-2"></i>
                                            0812-3456-7890
                                        </p>
                                        <p class="flex items-center mt-2">
                                            <i class="fas fa-clock mr-2"></i>
                                            08.00 - 20.00 (Buka Sekarang)
                                        </p>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <button class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                            Lihat Detail
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- UMKM Card 2 -->
                            <div class="umkm-card bg-white dark:bg-gray-700">
                                <div class="p-5">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-bold text-gray-900 dark:text-white">Toko Kerajinan Jaya</h4>
                                            <div class="mt-1 flex items-center">
                                                <span class="umkm-category-badge category-kerajinan">Kerajinan</span>
                                                <div class="flex text-amber-400 ml-3">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <span class="text-xs text-gray-500 dark:text-gray-300 ml-1">4.0</span>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="text-blue-600 dark:text-blue-400">
                                            <i class="fas fa-location-dot"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="mt-3 text-sm text-gray-600 dark:text-gray-300">
                                        <p class="flex items-center">
                                            <i class="fas fa-map-marker-alt mr-2"></i>
                                            Jl. Kenanga No. 27, Yogyakarta
                                        </p>
                                        <p class="flex items-center mt-2">
                                            <i class="fas fa-phone mr-2"></i>
                                            0813-4567-8901
                                        </p>
                                        <p class="flex items-center mt-2">
                                            <i class="fas fa-clock mr-2"></i>
                                            09.00 - 17.00 (Buka Sekarang)
                                        </p>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <button class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                            Lihat Detail
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- UMKM Card 3 -->
                            <div class="umkm-card bg-white dark:bg-gray-700">
                                <div class="p-5">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-bold text-gray-900 dark:text-white">Bengkel Motor Sejahtera</h4>
                                            <div class="mt-1 flex items-center">
                                                <span class="umkm-category-badge category-jasa">Jasa</span>
                                                <div class="flex text-amber-400 ml-3">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <span class="text-xs text-gray-500 dark:text-gray-300 ml-1">5.0</span>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="text-blue-600 dark:text-blue-400">
                                            <i class="fas fa-location-dot"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="mt-3 text-sm text-gray-600 dark:text-gray-300">
                                        <p class="flex items-center">
                                            <i class="fas fa-map-marker-alt mr-2"></i>
                                            Jl. Melati No. 8, Yogyakarta
                                        </p>
                                        <p class="flex items-center mt-2">
                                            <i class="fas fa-phone mr-2"></i>
                                            0815-6789-0123
                                        </p>
                                        <p class="flex items-center mt-2">
                                            <i class="fas fa-clock mr-2"></i>
                                            08.00 - 18.00 (Buka Sekarang)
                                        </p>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <button class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                            Lihat Detail
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button class="w-full py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg text-gray-800 dark:text-gray-200 font-medium">
                                Tampilkan Lebih Banyak
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        <!-- Footer -->
        <footer class="w-full gis-gradient mt-24 py-8">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center text-white">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-map-marker-alt"></i>
                        <span class="font-semibold">SIGAU</span>
                    </div>
                    
                    <div class="flex space-x-6">
                        <a href="#" class="hover:text-blue-200 transition">Tentang Kami</a>
                        <a href="#" class="hover:text-blue-200 transition">Kebijakan Privasi</a>
                        <a href="#" class="hover:text-blue-200 transition">Kontak</a>
                    </div>
                </div>
                
                <div class="mt-6 pt-6 border-t border-blue-400/20">
                    <p class="text-sm">
                        © {{ date('Y') }} SIGAU - Sistem Informasi Geografis Asosiasi UMKM<br>
                        All rights reserved
                    </p>
                </div>
            </div>
        </footer>
    </div>
    
    <script>
        // Initialize the public map
        function initPublicMap() {
            // Default location (Yogyakarta)
            const defaultLat = -7.7956;
            const defaultLng = 110.3695;
            
            // Create map
            const map = L.map('public-map').setView([defaultLat, defaultLng], 13);
            
            // Add tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            
            // Add sample UMKM markers
            const umkms = [
                {name: 'Warung Makan Sederhana', lat: -7.7950, lng: 110.3700, category: 'kuliner', rating: 4.5},
                {name: 'Toko Kerajinan Jaya', lat: -7.8000, lng: 110.3650, category: 'kerajinan', rating: 4.0},
                {name: 'Bengkel Motor Sejahtera', lat: -7.7900, lng: 110.3750, category: 'jasa', rating: 5.0},
                {name: 'Butik Fashion Modern', lat: -7.7850, lng: 110.3680, category: 'fashion', rating: 4.7},
                {name: 'Kedai Kopi Aroma', lat: -7.7920, lng: 110.3720, category: 'kuliner', rating: 4.8},
            ];
            
            umkms.forEach(umkm => {
                // Choose marker color based on category
                let markerColor;
                switch(umkm.category) {
                    case 'kuliner':
                        markerColor = '#F59E0B';
                        break;
                    case 'kerajinan':
                        markerColor = '#10B981';
                        break;
                    case 'jasa':
                        markerColor = '#3B82F6';
                        break;
                    case 'fashion':
                        markerColor = '#EC4899';
                        break;
                    default:
                        markerColor = '#6B7280';
                }
                
                // Create custom marker icon
                const markerIcon = L.divIcon({
                    className: 'custom-marker',
                    html: `<div style="background-color: ${markerColor}" class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                              <i class="fas fa-store text-xs"></i>
                           </div>`,
                    iconSize: [32, 32],
                    iconAnchor: [16, 32],
                    popupAnchor: [0, -32]
                });
                
                // Add marker to map
                const marker = L.marker([umkm.lat, umkm.lng], {icon: markerIcon}).addTo(map);
                
                // Add popup
                marker.bindPopup(`
                    <div class="font-bold text-gray-900">${umkm.name}</div>
                    <div class="mt-1 flex items-center">
                        <span class="umkm-category-badge category-${umkm.category}">
                            ${umkm.category.charAt(0).toUpperCase() + umkm.category.slice(1)}
                        </span>
                        <div class="flex text-amber-400 ml-2">
                            ${'<i class="fas fa-star"></i>'.repeat(Math.floor(umkm.rating))}
                            ${umkm.rating % 1 >= 0.5 ? '<i class="fas fa-star-half-alt"></i>' : ''}
                            <span class="text-xs text-gray-600 ml-1">${umkm.rating}</span>
                        </div>
                    </div>
                    <div class="mt-2">
                        <button class="text-sm text-blue-600 hover:underline">Lihat Detail</button>
                    </div>
                `);
            });
        }
        
        // Initialize map when page loads
        document.addEventListener('DOMContentLoaded', initPublicMap);
    </script>
</body>
</html>