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
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet-control-geocoder@1.13.0/dist/Control.Geocoder.css">

        @vite(['resources/css/app.css', 'resources/js/app.js' ])

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

    .icon-gradient {
    background: linear-gradient(135deg, #3B82F6 0%, #10B981 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    display: inline-block;
    }
    </style>
    @stack('styles')
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
                                        <i class="fas fa-users-cog mr-2 icon-gradient"></i>
                                        {{ __('User') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('searchs.index')" class="hover:bg-gray-100">
                                        <i class="fas fa-search-location mr-2 icon-gradient"></i>
                                        {{ __('Searchs') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('umkms.index')" class="hover:bg-gray-100">
                                        <i class="fas fa-store mr-2 icon-gradient"></i>
                                        {{ __('UMKM') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('inventories.index')" class="hover:bg-gray-100">
                                        <i class="fas fa-box mr-2 icon-gradient"></i>
                                        {{ __('Inventory') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('inventories2.index')" class="hover:bg-gray-100">
                                        <i class="fas fa-box mr-2 icon-gradient"></i>
                                        {{ __('Inventory 2') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('categories.index')" class="hover:bg-gray-100">
                                        <i class="fas fa-list mr-2 icon-gradient"></i>
                                        {{ __('Categories') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('facilities.index')" class="hover:bg-gray-100">
                                        <i class="fas fa-tools mr-2 icon-gradient"></i>
                                        {{ __('Facility') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.packages.index')" class="hover:bg-gray-100">
                                        <i class="fas fa-box-open mr-2 icon-gradient"></i>
                                        {{ __('Package') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.transactions.index')" class="hover:bg-gray-100">
                                        <i class="fas fa-dollar mr-2 icon-gradient"></i>
                                        {{ __('Transaction') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                            @endif
                            @endauth
                        </div>
                    </div>

                    <!-- Right Section -->
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center space-x-1 transition-all duration-200 hover:scale-105 focus:outline-none group">
                                    <!-- Avatar dengan inisial -->
                                    <div class="relative">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-500 to-purple-500 flex items-center justify-center text-white font-semibold shadow-sm">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                        <div class="absolute bottom-0 right-0 w-2 h-2 bg-green-500 rounded-full ring-2 ring-white dark:ring-gray-800"></div>
                                    </div>

                                    <div class="flex items-center space-x-1">
                                        <span class="text-sm font-medium text-white dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                            {{ Auth::user()->name }}
                                        </span>
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 group-hover:text-blue-500 transition-transform transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <!-- Header Profil -->
                                <div class="px-4 py-3 border-b dark:border-gray-700">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
                                </div>

                                <!-- Menu Items -->
                                <div class="py-1 space-y-1">
                                    <x-dropdown-link :href="route('profile.edit')" class="group flex items-center px-4 py-2 text-sm transition-all duration-200 hover:bg-blue-50 dark:hover:bg-gray-700">
                                        <svg class="w-5 h-5 mr-3 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span class="transform transition-transform group-hover:translate-x-1">{{ __('Profile') }}</span>
                                    </x-dropdown-link>

                                    <!-- Tombol Registrasi UMKM -->
                                    <x-dropdown-link :href="route('umkms.create')" class="group flex items-center px-4 py-2 text-sm transition-all duration-200 hover:bg-green-50 dark:hover:bg-gray-700">
                                        <svg class="w-5 h-5 mr-3 text-gray-500 dark:text-gray-400 group-hover:text-green-600 dark:group-hover:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <span class="transform transition-transform group-hover:translate-x-1">{{ __('Registrasi UMKM') }}</span>
                                    </x-dropdown-link>

                                    <!-- Logout -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="group flex items-center px-4 py-2 text-sm transition-all duration-200 hover:bg-red-50 dark:hover:bg-gray-700">
                                            <svg class="w-5 h-5 mr-3 text-gray-500 dark:text-gray-400 group-hover:text-red-600 dark:group-hover:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            <span class="transform transition-transform group-hover:translate-x-1">{{ __('Log Out') }}</span>
                                        </x-dropdown-link>
                                    </form>
                                </div>
                            </x-slot>
                        </x-dropdown>
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
                <x-toast-success :message="session('success')" class="hover-scale" />
                @elseif(session()->has('error'))
                <x-toast-error :message="session('error')" class="hover-scale" />
                @elseif(session()->has('warning'))
                <x-toast-warning :message="session('warning')" class="hover-scale" />
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
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder@1.13.0/dist/Control.Geocoder.js"></script>
    @stack('scripts')
</body>

</html>