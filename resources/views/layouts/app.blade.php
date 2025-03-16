<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SIGAU - Sistem Informasi Geografis UMKM</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>   
     

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .bg-gis-gradient {
            background: linear-gradient(135deg, #3B82F6 0%, #10B981 100%);
        }
        .hover-scale {
            transition: transform 0.2s ease-in-out;
        }
        .hover-scale:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
<nav class="bg-gis-gradient shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                    <i class="fas fa-map-marker-alt text-white text-2xl"></i>
                    <span class="text-white font-bold text-xl">SIGAU</span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-4">
                    @auth
                        <x-nav-link :href="route('dashboard')" class="text-white hover:bg-blue-700/20">
                            <i class="fas fa-tachometer-alt mr-2"></i>{{ __('Dashboard') }}
                        </x-nav-link>
                        
                        <!-- Admin Dropdown -->
                        @if(Auth::user()->role === 'admin')
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="text-white flex items-center space-x-1 px-4 py-2 hover:bg-blue-700/20 rounded-lg transition-colors">
                                    <i class="fas fa-cog mr-1"></i>
                                    <span>Admin</span>
                                    <i class="fas fa-chevron-down text-xs mt-1"></i>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('users.index')" class="hover:bg-gray-100">
                                    <i class="fas fa-users-cog mr-2 text-blue-500"></i>
                                    {{ __('User') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('searchs.index')" class="hover:bg-gray-100">
                                    <i class="fas fa-search-location mr-2 text-green-500"></i>
                                    {{ __('Searchs') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('umkms.index')" class="hover:bg-gray-100">
                                    <i class="fas fa-store mr-2 text-purple-500"></i>
                                    {{ __('UMKM') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('inventories.index')" class="hover:bg-gray-100">
                                    <i class="fas fa-box mr-2 text-purple-500"></i>
                                    {{ __('Inventory') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('categories.index')" class="hover:bg-gray-100">
                                    <i class="fas fa-list mr-2 text-orange-500"></i>
                                    {{ __('Categories') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right Section -->
            <div class="flex items-center">
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <div class="flex items-center text-white space-x-2 cursor-pointer hover:bg-blue-700/20 px-4 py-2 rounded-lg">
                            <span>{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-sm"></i>
                        </div>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-gray-100">
                            <i class="fas fa-user-edit mr-2 text-gray-600"></i>{{ __('Profile') }}
                        </x-dropdown-link>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" 
                                            class="hover:bg-gray-100"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt mr-2 text-red-500"></i>{{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-white px-4 py-2 rounded-lg hover:bg-blue-700/20">
                        {{ __('Login') }}
                    </a>
                    <a href="{{ route('register') }}" class="text-white px-4 py-2 rounded-lg hover:bg-blue-700/20 ml-2">
                        {{ __('Register') }}
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

        <!-- Page Content -->
        <main class="flex-1">
            <!-- Toast Notifications -->
            <div class="fixed top-4 right-4 z-50 space-y-2">
                @if (session()->has('success'))
                    <x-toast-success :message="session('success')" class="hover-scale"/>
                @elseif(session()->has('error'))
                    <x-toast-error :message="session('error')" class="hover-scale"/>
                @elseif(session()->has('warning'))
                    <x-toast-warning :message="session('warning')" class="hover-scale"/>
                @endif
            </div>

            <!-- Page Header -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex items-center">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                            @yield('header-icon')
                            {{ $header }}
                        </h2>
                    </div>
                </header>
            @endisset

            <!-- Main Content -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-gis-gradient mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <p class="mb-2">
                <i class="fas fa-map-marked-alt mr-2"></i>
                SIGAU - Sistem Informasi Geografis Asosiasi UMKM
            </p>
            <p class="text-sm opacity-80">
                © {{ date('Y') }} All rights reserved
            </p>
        </div>
    </footer>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>   
    <script src="//unpkg.com/alpinejs" defer></script>
 
</body>
</html>