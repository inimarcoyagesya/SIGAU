<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-white">
            <i class="fas fa-user-plus mr-2"></i>Daftar Akun Baru
        </h2>
    </x-slot>

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-50 to-green-50 dark:from-gray-800 dark:to-gray-900">
        <div class="w-full max-w-md px-6 py-8 bg-white rounded-2xl shadow-xl dark:bg-gray-800 transition-all duration-300">
            <!-- Session Status -->
            <x-auth-session-status class="mb-6 p-4 bg-blue-100 text-blue-800 rounded-lg dark:bg-blue-900 dark:text-blue-300" :status="session('status')" />

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Logo -->
                <div class="flex justify-center mb-8">
                    <x-application-logo class="w-32" />
                </div>

                <!-- Name -->
                <div class="mb-6">
                    <x-input-label for="name" :value="__('Nama Lengkap')" class="text-gray-700 dark:text-gray-300" />
                    <div class="relative mt-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400 dark:text-gray-500"></i>
                        </div>
                        <x-text-input 
                            id="name" 
                            type="text" 
                            name="name" 
                            :value="old('name')" 
                            class="pl-10 w-full"
                            required 
                            autofocus 
                            autocomplete="name"
                        />
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700 dark:text-gray-300" />
                    <div class="relative mt-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400 dark:text-gray-500"></i>
                        </div>
                        <x-text-input 
                            id="email" 
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            class="pl-10 w-full"
                            required 
                            autocomplete="email"
                        />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Phone Number -->
                <div class="mb-6">
                    <x-input-label for="phone" :value="__('Nomor Telepon')" class="text-gray-700 dark:text-gray-300" />
                    <div class="relative mt-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-phone text-gray-400 dark:text-gray-500"></i>
                        </div>
                        <x-text-input 
                            id="phone" 
                            type="tel" 
                            name="phone" 
                            :value="old('phone')" 
                            class="pl-10 w-full"
                            required 
                            autocomplete="tel"
                        />
                    </div>
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- Address -->
                <div class="mb-6">
                    <x-input-label for="address" :value="__('Alamat')" class="text-gray-700 dark:text-gray-300" />
                    <div class="relative mt-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-map-marker-alt text-gray-400 dark:text-gray-500"></i>
                        </div>
                        <x-text-input 
                            id="address" 
                            type="text" 
                            name="address" 
                            :value="old('address')" 
                            class="pl-10 w-full"
                            required 
                            autocomplete="street-address"
                        />
                    </div>
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700 dark:text-gray-300" />
                    <div class="relative mt-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400 dark:text-gray-500"></i>
                        </div>
                        <x-text-input 
                            id="password" 
                            type="password" 
                            name="password" 
                            class="pl-10 w-full"
                            required 
                            autocomplete="new-password"
                        />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-gray-700 dark:text-gray-300" />
                    <div class="relative mt-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400 dark:text-gray-500"></i>
                        </div>
                        <x-text-input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            class="pl-10 w-full"
                            required 
                            autocomplete="new-password"
                        />
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Terms Checkbox -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="terms" 
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                            required
                        >
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                            Saya setuju dengan 
                            <a href="#" class="text-green-600 hover:text-green-700 dark:text-green-400">Syarat & Ketentuan</a>
                        </span>
                    </label>
                </div>

                <!-- Register Button -->
                <x-primary-button class="w-full bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700">
                    <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                </x-primary-button>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Sudah punya akun?
                        <a 
                            href="{{ route('login') }}" 
                            class="font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                        >
                            Masuk disini
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>