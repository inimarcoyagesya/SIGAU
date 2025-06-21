<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-white">
            <i class="fas fa-store mr-2"></i>Profil UMKM
        </h2>
    </x-slot>

    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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
            height: 300px;
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
        
        .profile-card {
            background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .dark .profile-card {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
        }
        
        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .form-input {
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }
        
        .dark .form-input {
            background-color: #374151;
            border-color: #4b5563;
            color: #f3f4f6;
        }
        
        .form-input:focus {
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
        
        .dark .form-input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3B82F6 0%, #2563eb 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
        }
        
        .section-title {
            position: relative;
            display: inline-block;
            padding-bottom: 10px;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 4px;
            background: linear-gradient(90deg, #3B82F6, #10B981);
            border-radius: 2px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        }
        
        .dark .stat-card {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
        }
        
        .file-upload {
            border: 2px dashed #d1d5db;
            border-radius: 0.75rem;
            cursor: pointer;
            transition: border-color 0.3s ease;
        }
        
        .dark .file-upload {
            border-color: #4b5563;
        }
        
        .file-upload:hover {
            border-color: #3B82F6;
        }
        
        .profile-pic-container {
            position: relative;
            display: inline-block;
        }
        
        .profile-pic-edit {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: #3B82F6;
            color: white;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
    @endpush

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Profil UMKM
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    Kelola informasi usaha Anda dan tingkatkan visibilitas
                </p>
            </div>
            
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                        <span class="text-green-800 dark:text-green-200">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Left Column -->
                <div class="lg:col-span-1">
                    <div class="profile-card p-6 mb-6">
                        <div class="flex flex-col items-center mb-6">
                            <div class="profile-pic-container mb-4">
                                @if($umkm->foto_usaha)
                                    <img src="{{ asset('storage/' . $umkm->foto_usaha) }}" alt="Foto UMKM" class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                                @else
                                    <div class="w-32 h-32 rounded-full bg-gray-200 border-4 border-white shadow-lg flex items-center justify-center">
                                        <i class="fas fa-store text-gray-400 text-4xl"></i>
                                    </div>
                                @endif
                                <div class="profile-pic-edit" onclick="document.getElementById('foto_usaha').click()">
                                    <i class="fas fa-camera"></i>
                                </div>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $umkm->nama_usaha }}</h2>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mt-1">
                                {{ $umkm->category->nama_kategori ?? 'Belum ada kategori' }}
                            </p>
                            <div class="flex items-center mt-2">
                                <div class="flex text-amber-400">
                                    @php
                                        $rating = is_numeric($umkm->rating) ? $umkm->rating : 0;
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
                                <span class="text-sm text-gray-500 dark:text-gray-400 ml-2">
                                    {{ number_format($rating, 1) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mr-3">
                                    <i class="fas fa-store text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">Status</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $umkm->status == 'active' ? 'Aktif' : 'Nonaktif' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center mr-3">
                                    <i class="fas fa-calendar-check text-green-600 dark:text-green-400"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">Bergabung</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $umkm->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center mr-3">
                                    <i class="fas fa-box text-purple-600 dark:text-purple-400"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">Produk</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $productCount }} Item</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="profile-card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Statistik UMKM</h3>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Pengunjung</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">1.2K</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: 75%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Penjualan</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">48</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: 60%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Kepuasan</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">94%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-amber-500 h-2 rounded-full" style="width: 94%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="lg:col-span-3">
                    <div class="profile-card p-6 mb-6">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white section-title">Edit Profil UMKM</h2>
                                <p class="text-gray-600 dark:text-gray-400 mt-2">Perbarui informasi usaha Anda</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('umkm.dashboard') }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg font-medium flex items-center hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                                </a>
                            </div>
                        </div>
                        
                        <form method="POST" action="{{ route('umkm.profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="nama_usaha">
                                        Nama Usaha
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-store text-gray-400"></i>
                                        </div>
                                        <input type="text" id="nama_usaha" name="nama_usaha" class="form-input pl-10 w-full rounded-lg p-3" placeholder="Nama usaha Anda" value="{{ old('nama_usaha', $umkm->nama_usaha) }}">
                                    </div>
                                    @error('nama_usaha')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="category_id">
                                        Kategori
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-tag text-gray-400"></i>
                                        </div>
                                        <select id="category_id" name="category_id" class="form-input pl-10 w-full rounded-lg p-3">
                                            <option value="">Pilih kategori</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ $umkm->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('category_id')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="alamat">
                                    Alamat
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 pt-3 flex items-start pointer-events-none">
                                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                                    </div>
                                    <textarea id="alamat" name="alamat" class="form-input pl-10 w-full rounded-lg p-3" rows="3" placeholder="Alamat lengkap usaha">{{ old('alamat', $umkm->alamat) }}</textarea>
                                </div>
                                @error('alamat')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="kontak">
                                        Kontak
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-phone text-gray-400"></i>
                                        </div>
                                        <input type="text" id="kontak" name="kontak" class="form-input pl-10 w-full rounded-lg p-3" placeholder="Nomor telepon/WA" value="{{ old('kontak', $umkm->kontak) }}">
                                    </div>
                                    @error('kontak')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="jam_operasional">
                                        Jam Operasional
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-clock text-gray-400"></i>
                                        </div>
                                        <input type="text" id="jam_operasional" name="jam_operasional" class="form-input pl-10 w-full rounded-lg p-3" placeholder="Contoh: 08:00 - 17:00" value="{{ old('jam_operasional', $umkm->jam_operasional) }}">
                                    </div>
                                    @error('jam_operasional')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="deskripsi">
                                    Deskripsi
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 pt-3 flex items-start pointer-events-none">
                                        <i class="fas fa-file-alt text-gray-400"></i>
                                    </div>
                                    <textarea id="deskripsi" name="deskripsi" class="form-input pl-10 w-full rounded-lg p-3" rows="4" placeholder="Deskripsikan usaha Anda">{{ old('deskripsi', $umkm->deskripsi) }}</textarea>
                                </div>
                                @error('deskripsi')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-8">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Foto Usaha
                                </label>
                                <div class="flex items-start space-x-6">
                                    <div class="file-upload w-48 h-48 flex flex-col items-center justify-center rounded-lg relative">
                                        <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-2"></i>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 text-center px-4">Klik untuk mengunggah foto</p>
                                        <input type="file" id="foto_usaha" name="foto_usaha" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Format yang didukung: JPG, PNG</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Ukuran maksimal: 5MB</p>
                                        @error('foto_usaha')
                                            <p class="error-message mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                                <button type="reset" class="px-6 py-3 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors mr-4">
                                    <i class="fas fa-times mr-2"></i> Reset
                                </button>
                                <button type="submit" class="btn-primary px-6 py-3 text-white rounded-lg font-medium">
                                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="profile-card p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <i class="fas fa-map-marked-alt text-blue-500 mr-2"></i> Lokasi UMKM
                            </h3>
                            
                            @if($umkm->latitude && $umkm->longitude)
                                <div id="umkm-map" class="mb-4"></div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Latitude</p>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $umkm->latitude }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Longitude</p>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $umkm->longitude }}</p>
                                    </div>
                                </div>
                                
                                <form method="POST" action="{{ route('umkm.profile.location') }}" class="mt-4">
                                    @csrf
                                    <div class="flex items-end space-x-2">
                                        <div class="flex-1">
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Atur Ulang Lokasi
                                            </label>
                                            <div class="grid grid-cols-2 gap-2">
                                                <input type="number" step="any" name="latitude" class="form-input w-full rounded-lg p-2" placeholder="Latitude" required>
                                                <input type="number" step="any" name="longitude" class="form-input w-full rounded-lg p-2" placeholder="Longitude" required>
                                            </div>
                                        </div>
                                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                                            <i class="fas fa-map-marker-alt mr-2"></i> Update
                                        </button>
                                    </div>
                                </form>
                            @else
                                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4 mb-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-exclamation-triangle text-yellow-500 text-xl mr-3"></i>
                                        <div>
                                            <p class="text-yellow-800 dark:text-yellow-200">Lokasi belum ditentukan</p>
                                            <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">
                                                Tambahkan koordinat lokasi untuk ditampilkan di peta
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <form method="POST" action="{{ route('umkm.profile.location') }}">
                                    @csrf
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Latitude
                                            </label>
                                            <input type="number" step="any" name="latitude" class="form-input w-full rounded-lg p-3" placeholder="Contoh: -6.178546" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Longitude
                                            </label>
                                            <input type="number" step="any" name="longitude" class="form-input w-full rounded-lg p-3" placeholder="Contoh: 106.839054" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="mt-4 px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-map-marker-alt mr-2"></i> Simpan Lokasi
                                    </button>
                                </form>
                            @endif
                        </div>
                        
                        <div class="profile-card p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <i class="fas fa-chart-line text-green-500 mr-2"></i> Statistik Tambahan
                            </h3>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mr-3">
                                            <i class="fas fa-users text-blue-600 dark:text-blue-400"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600 dark:text-gray-300">Pelanggan Aktif</p>
                                            <p class="font-medium text-gray-900 dark:text-white">128 Orang</p>
                                        </div>
                                    </div>
                                    <span class="text-sm bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 px-2 py-1 rounded-full">
                                        +12.5%
                                    </span>
                                </div>
                                
                                <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center mr-3">
                                            <i class="fas fa-shopping-cart text-purple-600 dark:text-purple-400"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600 dark:text-gray-300">Pesanan Bulan Ini</p>
                                            <p class="font-medium text-gray-900 dark:text-white">42 Pesanan</p>
                                        </div>
                                    </div>
                                    <span class="text-sm bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 px-2 py-1 rounded-full">
                                        +8.3%
                                    </span>
                                </div>
                                
                                <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center mr-3">
                                            <i class="fas fa-star text-amber-500 dark:text-amber-400"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600 dark:text-gray-300">Ulasan Terbaru</p>
                                            <p class="font-medium text-gray-900 dark:text-white">4.8/5.0</p>
                                        </div>
                                    </div>
                                    <span class="text-sm bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 px-2 py-1 rounded-full">
                                        +0.2
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Initialize the map if coordinates exist
        function initMap() {
            const map = L.map('umkm-map').setView([{{ $umkm->latitude }}, {{ $umkm->longitude }}], 15);
            
            // Add tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            
            // Add marker
            L.marker([{{ $umkm->latitude }}, {{ $umkm->longitude }}]).addTo(map)
                .bindPopup('<b>{{ $umkm->nama_usaha }}</b><br>{{ $umkm->alamat }}')
                .openPopup();
        }
        
        // Preview uploaded image
        function initImagePreview() {
            document.getElementById('foto_usaha').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const profilePic = document.querySelector('.profile-pic-container img') || 
                                        document.querySelector('.profile-pic-container div');
                        if (profilePic) {
                            if (profilePic.tagName === 'IMG') {
                                profilePic.src = e.target.result;
                            } else {
                                // Replace placeholder with image
                                const newImg = document.createElement('img');
                                newImg.src = e.target.result;
                                newImg.classList.add('w-32', 'h-32', 'rounded-full', 'object-cover', 'border-4', 'border-white', 'shadow-lg');
                                profilePic.parentNode.replaceChild(newImg, profilePic);
                            }
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
        
        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            @if($umkm->latitude && $umkm->longitude)
                initMap();
            @endif
            initImagePreview();
        });
    </script>
    @endpush
</x-app-layout>