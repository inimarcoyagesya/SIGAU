<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SIGAU - Sistem Informasi Geografis UMKM</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen minimalist-bg dark:bg-gray-900">
        <div class="relative flex flex-col items-center justify-center min-h-screen selection:bg-blue-600 selection:text-white">
            <!-- Navigation -->
            <nav class="w-full absolute top-0 gis-gradient shadow-lg">
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
            <main class="relative w-full max-w-7xl px-6 lg:px-8 mt-20">
                <div class="text-center py-16 space-y-8">
                    <div class="relative inline-block">
                        <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-green-500 blur-2xl opacity-15 rounded-full"></div>
                        <h1 class="relative text-4xl md:text-6xl font-bold text-gray-900 dark:text-white mb-6">
                            Selamat Datang di SIGAU
                            <i class="fas fa-map-marked-alt text-blue-600 ml-2"></i>
                        </h1>
                    </div>
                    
                    <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-3xl mx-auto">
                        Sistem Informasi Geografis terintegrasi untuk memetakan dan mengelola Usaha Mikro, Kecil, dan Menengah (UMKM) secara efisien.
                    </p>

                    <div class="flex flex-col md:flex-row justify-center gap-6">
                        <a href="{{ route('public.map') }}" class="gis-gradient hover:opacity-90 text-white px-8 py-4 rounded-xl text-lg font-semibold hover-scale transition">
                            <i class="fas fa-sign-in-alt mr-2"></i>Lihat Peta
                        </a>
                    </div>
                </div>

                <!-- Feature Cards -->
                <div class="grid gap-8 md:grid-cols-3 lg:gap-12 py-12">
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg hover-scale transition">
                        <div class="text-blue-600 dark:text-blue-400 text-4xl mb-4">
                            <i class="fas fa-map-location-dot"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4">Pemetaan UMKM</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Visualisasi lokasi UMKM secara real-time dengan integrasi peta digital
                        </p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg hover-scale transition">
                        <div class="text-green-600 dark:text-green-400 text-4xl mb-4">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4">Analisis Bisnis</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Laporan dan statistik perkembangan UMKM berbasis data geografis
                        </p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg hover-scale transition">
                        <div class="text-purple-600 dark:text-purple-400 text-4xl mb-4">
                            <i class="fas fa-users-gear"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4">Kolaborasi</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Sistem terintegrasi untuk kerjasama antara UMKM dan stakeholders
                        </p>
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
    </div>
</body>
</html>