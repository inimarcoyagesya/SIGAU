<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-white">
            <i class="fas fa-store mr-2"></i>Dashboard UMKM
        </h2>
    </x-slot>

    @push('styles')
    <style>
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

        .promotion-card {
            transition: all 0.3s ease;
            border-radius: 16px;
            overflow: hidden;
            position: relative;
        }
        
        .promotion-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .coupon-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, #3B82F6 0%, #10B981 100%);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .ad-platform {
            display: flex;
            align-items: center;
            padding: 15px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .ad-platform:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
        }
        
        .stats-card {
            background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .dark .stats-card {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
        }
        
        .social-media-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-media-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .social-media-item:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
        }
        
        .product-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .product-item {
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 5px 15px -3px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .product-item:hover {
            transform: translateY(-5px);
        }
        
        .chart-container {
            height: 250px;
            position: relative;
        }
        
        .tabs {
            display: flex;
            border-bottom: 2px solid #e5e7eb;
            margin-bottom: 20px;
        }
        
        .dark .tabs {
            border-bottom: 2px solid #4b5563;
        }
        
        .tab {
            padding: 12px 25px;
            cursor: pointer;
            font-weight: 600;
            color: #6b7280;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
        }
        
        .dark .tab {
            color: #9ca3af;
        }
        
        .tab.active {
            color: #3B82F6;
            border-bottom: 3px solid #3B82F6;
        }
        
        .dark .tab.active {
            color: #60a5fa;
            border-bottom: 3px solid #60a5fa;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
    </style>
    @endpush

    <div class="minimalist-bg dark:bg-gray-900 py-8">
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
                        <a href="{{ route('umkm.penalty') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none transition">
                            Bayar Denda Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Tabs Navigation -->
        <div class="tabs">
            <div class="tab active" data-tab="dashboard">Dashboard</div>
            <div class="tab" data-tab="promotion">Promosi & Kupon</div>
            <div class="tab" data-tab="ads">Iklan</div>
            <div class="tab" data-tab="analytics">Analitik</div>
        </div>

        <!-- Tab Content -->
        <div class="tab-content active" id="dashboard-tab">
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
                        
                        @if($userUmkm && $userUmkm->latitude && $userUmkm->longitude)
                            <!-- Tampilkan map normal -->
                            <div id="umkm-map"></div>
                        @else
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 rounded-xl p-6">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-triangle text-yellow-500 text-2xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-medium text-yellow-800 dark:text-yellow-200">
                                            Lokasi Belum Ditentukan
                                        </h3>
                                        <div class="mt-2 text-yellow-700 dark:text-yellow-300">
                                            <p>
                                                Anda belum menambahkan koordinat lokasi UMKM. 
                                                Silakan lengkapi profil UMKM untuk menampilkan peta.
                                            </p>
                                        </div>
                                        <div class="mt-4">
                                            <a href="{{ route('umkm.profile') }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none transition">
                                                Lengkapi Profil
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
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
                            
                            <a href="{{ route('umkm.premium') }}" class="quick-action-card">
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
                            @forelse($competitors as $competitor)
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    @if($competitor->foto_usaha)
                                    <img 
                                        src="{{ asset('storage/' . $competitor->foto_usaha) }}" 
                                        alt="{{ $competitor->nama_usaha }}"
                                        class="w-10 h-10 rounded-full object-cover"
                                    >
                                    @else
                                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-store text-gray-600"></i>
                                    </div>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $competitor->nama_usaha }}
                                    </p>
                                    <div class="flex items-center mt-1">
                                        <div class="flex text-amber-400">
                                            @php
                                                $rating = is_numeric($competitor->rating) ? (float) $competitor->rating : 0;
                                                $fullStars = floor($rating);
                                                $halfStar = ceil($rating - $fullStars);
                                                $emptyStars = 5 - $fullStars - $halfStar;
                                            @endphp
                                            
                                            @for($i = 0; $i < $fullStars; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                            
                                            @for($i = 0; $i < $halfStar; $i++)
                                                <i class="fas fa-star-half-alt"></i>
                                            @endfor
                                            
                                            @for($i = 0; $i < $emptyStars; $i++)
                                                <i class="far fa-star"></i>
                                            @endfor
                                        </div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">
                                            {{ number_format($rating, 1) }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        <i class="fas fa-location-dot mr-1"></i> 
                                        @if(isset($competitor->distance) && is_numeric($competitor->distance))
                                            {{ number_format($competitor->distance, 1) }} km dari lokasi Anda
                                        @else
                                            Jarak tidak tersedia
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400 py-4 text-center">
                                @if($userUmkm && $userUmkm->latitude)
                                    Tidak ada kompetitor dalam radius 5km
                                @else
                                    Lengkapi profil UMKM untuk melihat kompetitor terdekat
                                @endif
                            </p>
                            @endforelse
                        </div>
                        
                        @if($competitors->count() > 0)
                        <div class="mt-4">
                            <a href="{{ route('umkm.competitors') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                Lihat Semua Kompetitor
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Promotion Tab -->
        <div class="tab-content" id="promotion-tab">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Galeri Produk -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg mb-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                            <i class="fas fa-images mr-2 text-blue-500"></i> Galeri Produk
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            Unggah foto produk terbaik Anda untuk menarik perhatian pelanggan
                        </p>
                        
                        <div class="product-gallery">
                            @for($i = 1; $i <= 6; $i++)
                                <div class="product-item">
                                    <img src="https://via.placeholder.com/300x200?text=Produk+{{$i}}" alt="Produk {{$i}}" class="w-full h-40 object-cover">
                                    <div class="p-3 bg-white dark:bg-gray-700">
                                        <p class="font-medium text-gray-900 dark:text-white">Produk {{$i}}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-300">Rp {{ number_format(rand(50000, 500000), 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endfor
                        </div>
                        
                        <div class="mt-6">
                            <button class="btn-primary px-4 py-2 text-white rounded-lg font-medium">
                                <i class="fas fa-plus mr-2"></i> Tambah Produk
                            </button>
                        </div>
                    </div>
                    
                    <!-- Kupon & Diskon -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                            <i class="fas fa-ticket-alt mr-2 text-green-500"></i> Kupon & Diskon
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            Kelola kupon promosi untuk menarik lebih banyak pelanggan
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @for($i = 1; $i <= 4; $i++)
                                <div class="promotion-card bg-gradient-to-r from-blue-500 to-purple-600 text-white p-6">
                                    <div class="coupon-badge">Aktif</div>
                                    <h4 class="text-xl font-bold mb-2">Diskon {{ rand(10, 50) }}%</h4>
                                    <p class="mb-4">Min. pembelian Rp {{ number_format(rand(100000, 500000), 0, ',', '.') }}</p>
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-sm">Kode: <span class="font-bold">DISKON{{ strtoupper(Str::random(5)) }}</span></p>
                                            <p class="text-sm">Berlaku hingga: {{ now()->addDays(rand(5, 30))->format('d M Y') }}</p>
                                        </div>
                                        <button class="bg-white text-blue-600 px-3 py-1 rounded-lg font-medium">
                                            Salin
                                        </button>
                                    </div>
                                </div>
                            @endfor
                        </div>
                        
                        <div class="mt-6">
                            <button class="btn-primary px-4 py-2 text-white rounded-lg font-medium">
                                <i class="fas fa-plus mr-2"></i> Buat Kupon Baru
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Media Sosial -->
                <div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                            <i class="fas fa-share-alt mr-2 text-amber-500"></i> Media Sosial
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            Terhubung dengan pelanggan melalui platform media sosial
                        </p>
                        
                        <div class="social-media-grid">
                            <div class="social-media-item">
                                <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center mb-2">
                                    <i class="fab fa-facebook-f text-white text-xl"></i>
                                </div>
                                <span class="text-sm">Facebook</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">1.2K Pengikut</span>
                            </div>
                            
                            <div class="social-media-item">
                                <div class="w-12 h-12 rounded-full bg-pink-600 flex items-center justify-center mb-2">
                                    <i class="fab fa-instagram text-white text-xl"></i>
                                </div>
                                <span class="text-sm">Instagram</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">3.5K Pengikut</span>
                            </div>
                            
                            <div class="social-media-item">
                                <div class="w-12 h-12 rounded-full bg-blue-400 flex items-center justify-center mb-2">
                                    <i class="fab fa-twitter text-white text-xl"></i>
                                </div>
                                <span class="text-sm">Twitter</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">850 Pengikut</span>
                            </div>
                            
                            <div class="social-media-item">
                                <div class="w-12 h-12 rounded-full bg-red-600 flex items-center justify-center mb-2">
                                    <i class="fab fa-youtube text-white text-xl"></i>
                                </div>
                                <span class="text-sm">YouTube</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">2.1K Pelanggan</span>
                            </div>
                            
                            <div class="social-media-item">
                                <div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center mb-2">
                                    <i class="fab fa-whatsapp text-white text-xl"></i>
                                </div>
                                <span class="text-sm">WhatsApp</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">Terhubung</span>
                            </div>
                            
                            <div class="social-media-item">
                                <div class="w-12 h-12 rounded-full bg-purple-600 flex items-center justify-center mb-2">
                                    <i class="fas fa-store text-white text-xl"></i>
                                </div>
                                <span class="text-sm">Toko Online</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">Shopee/Tokopedia</span>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button class="btn-primary px-4 py-2 text-white rounded-lg font-medium">
                                <i class="fas fa-sync-alt mr-2"></i> Sinkronkan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ads Tab -->
        <div class="tab-content" id="ads-tab">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Iklan Aktif -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                            <i class="fas fa-ad mr-2 text-purple-500"></i> Iklan Aktif
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            Kelola kampanye iklan Anda untuk menjangkau lebih banyak pelanggan
                        </p>
                        
                        <div class="space-y-6">
                            @for($i = 1; $i <= 3; $i++)
                                <div class="promotion-card bg-white dark:bg-gray-700 p-6 border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-start">
                                        <div class="mr-4">
                                            <div class="w-16 h-16 rounded-lg overflow-hidden">
                                                <img src="https://via.placeholder.com/100x100?text=Ad+{{$i}}" alt="Iklan {{$i}}">
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Promo Produk {{$i}}</h4>
                                            <div class="flex items-center mb-2">
                                                <span class="bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-xs px-2 py-1 rounded mr-2">
                                                    Berjalan
                                                </span>
                                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                                    {{ now()->subDays(rand(1, 5))->format('d M') }} - {{ now()->addDays(rand(5, 15))->format('d M Y') }}
                                                </span>
                                            </div>
                                            <p class="text-gray-600 dark:text-gray-300 mb-3">
                                                Menampilkan produk terbaru dengan diskon spesial untuk pelanggan baru.
                                            </p>
                                            <div class="grid grid-cols-3 gap-4">
                                                <div>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">Tayangan</p>
                                                    <p class="font-bold text-gray-900 dark:text-white">{{ number_format(rand(1000, 5000)) }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">Klik</p>
                                                    <p class="font-bold text-gray-900 dark:text-white">{{ number_format(rand(100, 500)) }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">Konversi</p>
                                                    <p class="font-bold text-gray-900 dark:text-white">{{ number_format(rand(20, 100)) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                        
                        <div class="mt-6">
                            <button class="btn-primary px-4 py-2 text-white rounded-lg font-medium">
                                <i class="fas fa-plus mr-2"></i> Buat Iklan Baru
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Platform Iklan -->
                <div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                            <i class="fas fa-plug mr-2 text-green-500"></i> Platform Iklan
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            Terhubung dengan platform iklan untuk menjangkau lebih banyak pelanggan
                        </p>
                        
                        <div class="space-y-4">
                            <div class="ad-platform">
                                <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center mr-4">
                                    <i class="fab fa-google text-white text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 dark:text-white">Google Ads</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">Terhubung</p>
                                </div>
                            </div>
                            
                            <div class="ad-platform">
                                <div class="w-12 h-12 rounded-full bg-blue-800 flex items-center justify-center mr-4">
                                    <i class="fab fa-facebook text-white text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 dark:text-white">Meta Ads</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">Terhubung</p>
                                </div>
                            </div>
                            
                            <div class="ad-platform">
                                <div class="w-12 h-12 rounded-full bg-red-500 flex items-center justify-center mr-4">
                                    <i class="fab fa-tiktok text-white text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 dark:text-white">TikTok Ads</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">Belum Terhubung</p>
                                </div>
                            </div>
                            
                            <div class="ad-platform">
                                <div class="w-12 h-12 rounded-full bg-orange-500 flex items-center justify-center mr-4">
                                    <i class="fas fa-shopping-cart text-white text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 dark:text-white">Marketplace Ads</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">Shopee, Tokopedia</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button class="btn-primary px-4 py-2 text-white rounded-lg font-medium">
                                <i class="fas fa-link mr-2"></i> Hubungkan Platform
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics Tab -->
        <div class="tab-content" id="analytics-tab">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Grafik Statistik -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg mb-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                            <i class="fas fa-chart-line mr-2 text-blue-500"></i> Statistik Pengunjung
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            Pantau performa toko online Anda dari waktu ke waktu
                        </p>
                        
                        <div class="chart-container">
                            <!-- Placeholder for chart -->
                            <div class="bg-gray-100 dark:bg-gray-700 w-full h-full rounded-lg flex items-center justify-center">
                                <div class="text-center">
                                    <i class="fas fa-chart-bar text-4xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-600 dark:text-gray-300">Grafik statistik pengunjung</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-4 gap-4 mt-6">
                            <div class="stats-card p-4">
                                <p class="text-sm text-gray-600 dark:text-gray-300">Pengunjung Hari Ini</p>
                                <p class="text-xl font-bold text-gray-900 dark:text-white">142</p>
                            </div>
                            <div class="stats-card p-4">
                                <p class="text-sm text-gray-600 dark:text-gray-300">Klik Hari Ini</p>
                                <p class="text-xl font-bold text-gray-900 dark:text-white">78</p>
                            </div>
                            <div class="stats-card p-4">
                                <p class="text-sm text-gray-600 dark:text-gray-300">Konversi</p>
                                <p class="text-xl font-bold text-gray-900 dark:text-white">15</p>
                            </div>
                            <div class="stats-card p-4">
                                <p class="text-sm text-gray-600 dark:text-gray-300">Nilai Konversi</p>
                                <p class="text-xl font-bold text-gray-900 dark:text-white">Rp 2.1 jt</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Platform Sumber Trafik -->
                <div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                            <i class="fas fa-traffic-light mr-2 text-green-500"></i> Sumber Trafik
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            Dari mana pengunjung menemukan toko Anda
                        </p>
                        
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Pencarian Organik</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">42%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: 42%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Media Sosial</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">28%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: 28%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Iklan Berbayar</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">18%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-purple-600 h-2 rounded-full" style="width: 18%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Referral</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">12%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-amber-500 h-2 rounded-full" style="width: 12%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <h4 class="font-bold text-gray-900 dark:text-white mb-2">Performa Iklan</h4>
                            <div class="space-y-3">
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm text-gray-600 dark:text-gray-300">Google Ads</span>
                                        <span class="text-sm text-gray-900 dark:text-white">ROI: 320%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: 75%"></div>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm text-gray-600 dark:text-gray-300">Meta Ads</span>
                                        <span class="text-sm text-gray-900 dark:text-white">ROI: 240%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-blue-800 h-2 rounded-full" style="width: 60%"></div>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm text-gray-600 dark:text-gray-300">TikTok Ads</span>
                                        <span class="text-sm text-gray-900 dark:text-white">ROI: 180%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-red-500 h-2 rounded-full" style="width: 45%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    // Initialize the map
    function initMap() {
        // Data dari controller
        const userUmkm = @json($userUmkm);
        const competitors = @json($competitors);

        // Default location jika tidak ada data
        let defaultLat = -7.7956;
        let defaultLng = 110.3695;
        let zoomLevel = 13;

        // Gunakan lokasi UMKM user jika tersedia
        if (userUmkm && userUmkm.latitude && userUmkm.longitude) {
            defaultLat = parseFloat(userUmkm.latitude);
            defaultLng = parseFloat(userUmkm.longitude);
            zoomLevel = 15;
        }
        
        // Create map
        const map = L.map('umkm-map').setView([defaultLat, defaultLng], zoomLevel);
        
        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // Add user's UMKM marker jika ada data
        if (userUmkm && userUmkm.latitude && userUmkm.longitude) {
            const userMarker = L.marker([userUmkm.latitude, userUmkm.longitude]).addTo(map)
                .bindPopup(`
                    <b>${userUmkm.nama_usaha}</b><br>
                    ${userUmkm.alamat}<br>
                    <i class="fas fa-phone"></i> ${userUmkm.kontak}
                `)
                .openPopup();
                
            // Tambahkan custom icon jika perlu
            userMarker.setIcon(
                L.divIcon({
                    html: '<i class="fas fa-store text-2xl text-blue-600"></i>',
                    className: 'bg-transparent border-0',
                    iconSize: [30, 30]
                })
            );
        }
            
        // Add competitor markers
        competitors.forEach(competitor => {
            if (competitor.latitude && competitor.longitude) {
                const compMarker = L.marker([
                    parseFloat(competitor.latitude), 
                    parseFloat(competitor.longitude)
                ]).addTo(map)
                .bindPopup(`
                    <b>${competitor.nama_usaha}</b><br>
                    Kategori: ${competitor.category.nama_kategori}<br>
                    Jarak: ${calculateDistance(
                        defaultLat, 
                        defaultLng, 
                        parseFloat(competitor.latitude), 
                        parseFloat(competitor.longitude)
                    ).toFixed(1)} km
                `);
                
                compMarker.setIcon(
                    L.divIcon({
                        html: '<i class="fas fa-store text-xl text-red-500"></i>',
                        className: 'bg-transparent border-0',
                        iconSize: [24, 24]
                    })
                );
            }
        });
    }
    
    // Fungsi menghitung jarak (Haversine formula)
    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // Radius bumi dalam km
        const dLat = deg2rad(lat2 - lat1);
        const dLon = deg2rad(lon2 - lon1);
        const a = 
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
            Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
        return R * c;
    }
    
    function deg2rad(deg) {
        return deg * (Math.PI/180);
    }
    
    // Initialize map when page loads
    document.addEventListener('DOMContentLoaded', initMap);

    // Tab switching functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize map if needed
        @if($userUmkm && $userUmkm->latitude && $userUmkm->longitude)
            initMap();
        @endif
        
        // Tab functionality
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                tabs.forEach(t => t.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab
                tab.classList.add('active');
                
                // Show corresponding content
                const tabId = tab.getAttribute('data-tab');
                document.getElementById(`${tabId}-tab`).classList.add('active');
            });
        });
    });
    </script>
    @endpush
</x-app-layout>