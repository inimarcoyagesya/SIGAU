<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Paket Langganan</title>
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
        
        .shadow-soft {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
        
        .shadow-soft-dark {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
        
        .transition-smooth {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hover-scale {
            transition: transform 0.2s;
        }
        
        .hover-scale:hover {
            transform: scale(1.01);
        }
        
        .feature-list li:before {
            content: "✓";
            color: #10B981;
            font-weight: bold;
            display: inline-block;
            width: 1.5em;
            margin-left: -1.5em;
        }
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 transition-smooth">
    <x-app-layout>
        <x-slot name="header">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
                <i class="fas fa-box mr-2"></i>Manajemen Paket Langganan
            </h2>
        </x-slot>

        <div class="py-12" x-data="packageData()">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl transition-all duration-300">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <!-- Header dengan Fitur Pencarian dan Tambah Paket -->
                        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
                            <!-- Search Box -->
                            <div class="w-full md:w-96 relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input 
                                    type="text" 
                                    x-model="searchQuery"
                                    @input="searchPackages"
                                    class="block w-full pl-10 p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-300"
                                    placeholder="Cari paket langganan..."
                                >
                            </div>
                            <!-- Tambah Paket Button -->
                            <a href="{{ route('admin.packages.create') }}" class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 text-white rounded-lg transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-plus"></i>
                                <span>Paket Baru</span>
                            </a>
                        </div>

                        <!-- Alert -->
                        <div x-show="showSuccess" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 text-green-800 dark:bg-green-900/20 dark:border-green-800/30 dark:text-green-500">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="ml-3">
                                    <p x-text="successMessage"></p>
                                </div>
                                <button @click="showSuccess = false" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-green-900/30 dark:hover:bg-green-800/50">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Search and Filters -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-soft dark:shadow-soft-dark p-4 mb-6 transition-smooth">
                            <div class="flex flex-col md:flex-row gap-4">
                                <div class="w-full md:w-96 relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                    <input 
                                        type="text" 
                                        x-model="searchQuery"
                                        @input="searchPackages"
                                        class="block w-full pl-10 p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-300"
                                        placeholder="Cari paket langganan..."
                                    >
                                </div>
                                <div class="flex flex-wrap gap-3">
                                    <select x-model="statusFilter" @change="filterPackages" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="all">Semua Status</option>
                                        <option value="active">Aktif</option>
                                        <option value="inactive">Nonaktif</option>
                                    </select>
                                    <select x-model="durationFilter" @change="filterPackages" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="all">Semua Durasi</option>
                                        <option value="1">1 Bulan</option>
                                        <option value="3">3 Bulan</option>
                                        <option value="6">6 Bulan</option>
                                        <option value="12">1 Tahun</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Packages Table -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-soft dark:shadow-soft-dark overflow-hidden transition-smooth">
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600" @click="sortBy('name')">
                                                <div class="flex items-center justify-between">
                                                    Nama Paket
                                                    <div class="sort-icons inline-flex flex-col ml-2">
                                                        <i x-show="sortColumn === 'name' && sortDirection === 'asc'" class="fas fa-caret-up text-xs text-blue-500"></i>
                                                        <i x-show="sortColumn === 'name' && sortDirection === 'desc'" class="fas fa-caret-down text-xs text-blue-500"></i>
                                                        <i x-show="sortColumn !== 'name'" class="fas fa-caret-up text-xs opacity-50"></i>
                                                        <i x-show="sortColumn !== 'name'" class="fas fa-caret-down text-xs opacity-50"></i>
                                                    </div>
                                                </div>
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Deskripsi
                                            </th>
                                            <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600" @click="sortBy('price')">
                                                <div class="flex items-center justify-between">
                                                    Harga
                                                    <div class="sort-icons inline-flex flex-col ml-2">
                                                        <i x-show="sortColumn === 'price' && sortDirection === 'asc'" class="fas fa-caret-up text-xs text-blue-500"></i>
                                                        <i x-show="sortColumn === 'price' && sortDirection === 'desc'" class="fas fa-caret-down text-xs text-blue-500"></i>
                                                        <i x-show="sortColumn !== 'price'" class="fas fa-caret-up text-xs opacity-50"></i>
                                                        <i x-show="sortColumn !== 'price'" class="fas fa-caret-down text-xs opacity-50"></i>
                                                    </div>
                                                </div>
                                            </th>
                                            <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600" @click="sortBy('duration')">
                                                <div class="flex items-center justify-between">
                                                    Durasi
                                                    <div class="sort-icons inline-flex flex-col ml-2">
                                                        <i x-show="sortColumn === 'duration' && sortDirection === 'asc'" class="fas fa-caret-up text-xs text-blue-500"></i>
                                                        <i x-show="sortColumn === 'duration' && sortDirection === 'desc'" class="fas fa-caret-down text-xs text-blue-500"></i>
                                                        <i x-show="sortColumn !== 'duration'" class="fas fa-caret-up text-xs opacity-50"></i>
                                                        <i x-show="sortColumn !== 'duration'" class="fas fa-caret-down text-xs opacity-50"></i>
                                                    </div>
                                                </div>
                                            </th>
                                            <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600" @click="sortBy('status')">
                                                <div class="flex items-center justify-between">
                                                    Status
                                                    <div class="sort-icons inline-flex flex-col ml-2">
                                                        <i x-show="sortColumn === 'status' && sortDirection === 'asc'" class="fas fa-caret-up text-xs text-blue-500"></i>
                                                        <i x-show="sortColumn === 'status' && sortDirection === 'desc'" class="fas fa-caret-down text-xs text-blue-500"></i>
                                                        <i x-show="sortColumn !== 'status'" class="fas fa-caret-up text-xs opacity-50"></i>
                                                        <i x-show="sortColumn !== 'status'" class="fas fa-caret-down text-xs opacity-50"></i>
                                                    </div>
                                                </div>
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template x-for="package in filteredPackages" :key="package.id">
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-smooth hover-scale">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" x-text="package.name"></th>
                                                <td class="px-6 py-4 max-w-xs">
                                                    <div class="text-gray-600 dark:text-gray-300 line-clamp-2" x-text="package.description"></div>
                                                </td>
                                                <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white" x-text="package.price"></td>
                                                <td class="px-6 py-4" x-text="package.duration + ' Bulan'">
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span :class="package.status === 'Aktif' ? 'bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300'" x-text="package.status"></span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="flex justify-center space-x-3">
                                                        <a :href="'#'" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button @click="toggleStatus(package)" :class="package.status === 'Aktif' ? 'text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300' : 'text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300'">
                                                            <i :class="package.status === 'Aktif' ? 'fas fa-ban' : 'fas fa-check'"></i>
                                                        </button>
                                                        <button @click="deletePackage(package)" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                        
                                        <tr x-show="filteredPackages.length === 0">
                                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                                <div class="flex flex-col items-center justify-center">
                                                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="text-lg">Tidak ada paket yang ditemukan</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                                <nav class="flex items-center justify-between">
                                    <div class="text-sm text-gray-700 dark:text-gray-400">
                                        Menampilkan <span class="font-semibold" x-text="filteredPackages.length"></span> dari <span class="font-semibold" x-text="packages.length"></span> Paket
                                    </div>
                                    <ul class="inline-flex items-center -space-x-px">
                                        <li>
                                            <button @click="currentPage = Math.max(1, currentPage - 1)" :disabled="currentPage === 1" :class="currentPage === 1 ? 'cursor-not-allowed text-gray-300 dark:text-gray-600' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'" class="block px-3 py-2 ml-0 leading-tight bg-white border border-gray-300 rounded-l-lg dark:bg-gray-800 dark:border-gray-700">
                                                <i class="fas fa-chevron-left"></i>
                                            </button>
                                        </li>
                                        <li>
                                            <button @click="currentPage = 1" :class="currentPage === 1 ? 'z-10 px-3 py-2 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white' : 'px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'">1</button>
                                        </li>
                                        <li>
                                            <button @click="currentPage = 2" :class="currentPage === 2 ? 'z-10 px-3 py-2 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white' : 'px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'">2</button>
                                        </li>
                                        <li>
                                            <button @click="currentPage = 3" :class="currentPage === 3 ? 'z-10 px-3 py-2 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white' : 'px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'">3</button>
                                        </li>
                                        <li>
                                            <button @click="currentPage = currentPage + 1" :disabled="currentPage === 3" :class="currentPage === 3 ? 'cursor-not-allowed text-gray-300 dark:text-gray-600' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'" class="block px-3 py-2 leading-tight bg-white border border-gray-300 rounded-r-lg dark:bg-gray-800 dark:border-gray-700">
                                                <i class="fas fa-chevron-right"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>

    <script>
        function packageData() {
            return {
                searchQuery: '',
                statusFilter: 'all',
                durationFilter: 'all',
                sortColumn: 'name',
                sortDirection: 'asc',
                currentPage: 1,
                showSuccess: false,
                successMessage: '',
                packages: [
                    {
                        id: 1,
                        name: 'Paket Premium',
                        description: 'Akses penuh ke semua fitur premium dengan dukungan prioritas',
                        price: 'Rp 299.000',
                        duration: 12,
                        features: ['1000+ layer peta', 'Analisis lanjutan', 'Dukungan 24/7'],
                        status: 'Aktif'
                    },
                    {
                        id: 2,
                        name: 'Paket Bisnis',
                        description: 'Solusi lengkap untuk kebutuhan bisnis dengan fitur kolaborasi tim',
                        price: 'Rp 499.000',
                        duration: 6,
                        features: ['Kolaborasi tim', '500 layer peta', 'Ekspor data'],
                        status: 'Aktif'
                    },
                    {
                        id: 3,
                        name: 'Paket Dasar',
                        description: 'Paket awal untuk pengguna baru dengan fitur dasar',
                        price: 'Rp 99.000',
                        duration: 3,
                        features: ['100 layer peta', 'Analisis dasar', 'Dukungan email'],
                        status: 'Nonaktif'
                    },
                    {
                        id: 4,
                        name: 'Paket Enterprise',
                        description: 'Solusi khusus untuk perusahaan besar dengan kebutuhan khusus',
                        price: 'Rp 1.299.000',
                        duration: 12,
                        features: ['Unlimited layer', 'API khusus', 'Dedicated support'],
                        status: 'Aktif'
                    }
                ],
                get filteredPackages() {
                    let result = [...this.packages];
                    
                    // Filter by search query
                    if (this.searchQuery) {
                        const query = this.searchQuery.toLowerCase();
                        result = result.filter(p => 
                            p.name.toLowerCase().includes(query) || 
                            p.description.toLowerCase().includes(query)
                        );
                    }
                    
                    // Filter by status
                    if (this.statusFilter !== 'all') {
                        result = result.filter(p => 
                            this.statusFilter === 'active' ? p.status === 'Aktif' : p.status === 'Nonaktif'
                        );
                    }
                    
                    // Filter by duration
                    if (this.durationFilter !== 'all') {
                        result = result.filter(p => p.duration === parseInt(this.durationFilter));
                    }
                    
                    // Sorting
                    if (this.sortColumn === 'name') {
                        result.sort((a, b) => {
                            return this.sortDirection === 'asc' 
                                ? a.name.localeCompare(b.name) 
                                : b.name.localeCompare(a.name);
                        });
                    } else if (this.sortColumn === 'price') {
                        result.sort((a, b) => {
                            const priceA = parseInt(a.price.replace(/\D/g, ''));
                            const priceB = parseInt(b.price.replace(/\D/g, ''));
                            return this.sortDirection === 'asc' 
                                ? priceA - priceB 
                                : priceB - priceA;
                        });
                    } else if (this.sortColumn === 'duration') {
                        result.sort((a, b) => {
                            return this.sortDirection === 'asc' 
                                ? a.duration - b.duration 
                                : b.duration - a.duration;
                        });
                    } else if (this.sortColumn === 'status') {
                        result.sort((a, b) => {
                            return this.sortDirection === 'asc' 
                                ? a.status.localeCompare(b.status) 
                                : b.status.localeCompare(a.status);
                        });
                    }
                    
                    return result;
                },
                sortBy(column) {
                    if (this.sortColumn === column) {
                        this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
                    } else {
                        this.sortColumn = column;
                        this.sortDirection = 'asc';
                    }
                },
                toggleStatus(packageItem) {
                    packageItem.status = packageItem.status === 'Aktif' ? 'Nonaktif' : 'Aktif';
                    this.successMessage = `Status paket ${packageItem.name} berhasil diperbarui!`;
                    this.showSuccess = true;
                    setTimeout(() => this.showSuccess = false, 3000);
                },
                deletePackage(packageItem) {
                    if (confirm(`Apakah Anda yakin ingin menghapus paket ${packageItem.name}?`)) {
                        this.packages = this.packages.filter(p => p.id !== packageItem.id);
                        this.successMessage = `Paket ${packageItem.name} berhasil dihapus!`;
                        this.showSuccess = true;
                        setTimeout(() => this.showSuccess = false, 3000);
                    }
                },
                searchPackages() {
                    // Implementasi pencarian
                },
                filterPackages() {
                    // Implementasi filter
                }
            }
        }
    </script>
</body>
</html>