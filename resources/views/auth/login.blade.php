<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-white">
            <i class="fas fa-sign-in-alt mr-2"></i>Masuk ke SIGAU
        </h2>
    </x-slot>

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-50 to-green-50 dark:from-gray-800 dark:to-gray-900">
        <div class="w-full max-w-md px-6 py-8 bg-white rounded-2xl shadow-xl dark:bg-gray-800 transition-all duration-300">
            <!-- Session Status -->
            <x-auth-session-status class="mb-6 p-4 bg-blue-100 text-blue-800 rounded-lg dark:bg-blue-900 dark:text-blue-300" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Logo -->
                <div class="flex justify-center mb-8">
                    <x-application-logo class="w-32" />
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
                            autofocus 
                            autocomplete="email"
                        />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
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
                            autocomplete="current-password"
                        />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mb-6">
                    <label for="remember_me" class="flex items-center">
                        <input 
                            id="remember_me" 
                            type="checkbox" 
                            name="remember"
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                        >
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Ingat Saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a 
                            href="{{ route('password.request') }}" 
                            class="text-sm text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300"
                        >
                            Lupa Password?
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <x-primary-button class="w-full bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700">
                    <i class="fas fa-arrow-right-to-bracket mr-2"></i>Masuk
                </x-primary-button>

                <!-- Social Login -->
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500 dark:bg-gray-800 dark:text-gray-400">Atau masuk dengan</span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <a href="#" class="flex items-center justify-center p-2 border border-gray-300 rounded-lg hover:bg-gray-50 dark:border-gray-600 dark:hover:bg-gray-700 transition">
                            <i class="fab fa-google text-blue-600"></i>
                            <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Google</span>
                        </a>

                        <a href="#" class="flex items-center justify-center p-2 border border-gray-300 rounded-lg hover:bg-gray-50 dark:border-gray-600 dark:hover:bg-gray-700 transition">
                            <i class="fab fa-facebook text-blue-600"></i>
                            <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Facebook</span>
                        </a>
                    </div>
                </div>

                <!-- Register Link -->
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Belum punya akun?
                        <a 
                            href="{{ route('register') }}" 
                            class="font-medium text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300"
                        >
                            Daftar disini
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>