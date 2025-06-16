<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Paket Langganan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            500: '#3B82F6',
                            600: '#2563EB'
                        },
                        success: {
                            500: '#10B981',
                            600: '#059669'
                        },
                        danger: {
                            500: '#EF4444',
                            600: '#DC2626'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .btn-gradient {
            background: linear-gradient(to right, #3B82F6, #2563EB);
            color: white;
            border: none;
            border-radius: 0.375rem;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-gradient:hover {
            background: linear-gradient(to right, #2563EB, #1D4ED8);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.3);
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <x-app-layout>
        <x-slot name="header">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
                <i class="fas fa-box mr-2"></i>Tambah Paket Langganan
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form method="POST" action="{{ route('admin.packages.store') }}">
                            @csrf

                            {{-- Nama Paket --}}
                            <div class="mb-6">
                                <x-input-label for="name" :value="__('Nama Paket')" />
                                <x-text-input id="name" name="name" type="text"
                                    class="mt-1 block w-full" value="{{ old('name') }}" required autofocus 
                                    placeholder="Contoh: Paket Premium" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            {{-- Deskripsi --}}
                            <div class="mb-6">
                                <x-input-label for="description" :value="__('Deskripsi Paket')" />
                                <textarea id="description" name="description" rows="3"
                                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required placeholder="Jelaskan manfaat paket ini secara singkat">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            {{-- Harga & Durasi --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                {{-- Harga --}}
                                <div>
                                    <x-input-label for="price" :value="__('Harga')" />
                                    <div class="relative mt-1">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500">Rp</span>
                                        </div>
                                        <x-text-input 
                                            id="price" 
                                            name="price" 
                                            type="text"
                                            class="pl-10 w-full" 
                                            value="{{ old('price') }}" 
                                            required 
                                            placeholder="Contoh: 299000" />
                                    </div>
                                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                </div>
                                
                                {{-- Durasi --}}
                                <div>
                                    <x-input-label for="duration" :value="__('Durasi Langganan')" />
                                    <select id="duration" name="duration"
                                        class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        required>
                                        <option value="">{{ __('Pilih Durasi') }}</option>
                                        <option value="1" {{ old('duration') == '1' ? 'selected' : '' }}>1 Bulan</option>
                                        <option value="3" {{ old('duration') == '3' ? 'selected' : '' }}>3 Bulan</option>
                                        <option value="6" {{ old('duration') == '6' ? 'selected' : '' }}>6 Bulan</option>
                                        <option value="12" {{ old('duration') == '12' ? 'selected' : '' }}>1 Tahun</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                                </div>
                            </div>

                            {{-- Status Aktif --}}
                            <div class="mb-6 flex items-center">
                                <input id="is_active" name="is_active" type="checkbox"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    {{ old('is_active', true) ? 'checked' : '' }} />
                                <x-input-label for="is_active" :value="__('Aktifkan Paket')" class="ml-2" />
                            </div>

                            {{-- Buttons --}}
                            <div class="flex justify-end gap-4 mt-8">
                                <a href="{{ route('admin.packages.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg transition-colors duration-200">
                                    <i class="fas fa-times mr-2"></i>Batal
                                </a>
                                <button type="submit" class="btn-gradient px-4 py-2 flex items-center">
                                    <i class="fas fa-plus mr-2"></i>Tambah Paket
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>

    <script>
        // Format input harga
        document.getElementById('price').addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^\d]/g, '');
            e.target.value = value;
        });
    </script>
</body>
</html>