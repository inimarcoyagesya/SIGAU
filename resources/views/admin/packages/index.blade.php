<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Paket Langganan') }}
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
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                x-model="searchQuery"
                                @input="searchPackages"
                                class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-300"
                                placeholder="Cari paket..."
                            >
                        </div>
                        <!-- Tambah Paket Button -->
                        <a href="{{ route('admin.packages.create') }}" class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 text-white rounded-lg transition-all duration-300 transform hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Paket Baru</span>
                        </a>
                    </div>

                    <!-- Alert -->
                    <div x-show="showSuccess" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 text-green-800 dark:bg-green-900/20 dark:border-green-800/30 dark:text-green-500">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p x-text="successMessage"></p>
                            </div>
                            <button @click="showSuccess = false" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-green-900/30 dark:hover:bg-green-800/50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Filter -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 mb-6 dark:shadow-none">
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="w-full md:w-96 relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input 
                                    type="text" 
                                    x-model="searchQuery"
                                    @input="searchPackages"
                                    class="block w-full pl-10 p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Cari paket..."
                                >
                            </div>
                            <div class="flex flex-wrap gap-3">
                                <select x-model="statusFilter" @change="filterPackages" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="all">Semua Status</option>
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Nonaktif</option>
                                </select>
                                <select x-model="durationFilter" @change="filterPackages" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="all">Semua Durasi</option>
                                    <option value="1">1 Bulan</option>
                                    <option value="3">3 Bulan</option>
                                    <option value="6">6 Bulan</option>
                                    <option value="12">1 Tahun</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Paket -->
                    <div class="relative overflow-x-auto rounded-xl shadow-lg dark:shadow-none">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                    <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600" @click="sortBy('name')">
                                        <div class="flex items-center justify-between">
                                            Nama Paket
                                            <div class="sort-icons inline-flex flex-col ml-2">
                                                <svg class="w-2 h-2 fill-current opacity-50 sort-asc" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                                    <path d="M182.6 137.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8H288c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z"/>
                                                </svg>
                                                <svg class="w-2 h-2 fill-current opacity-50 sort-desc" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                                    <path d="M182.6 470.6c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-9.2-9.2-11.9-22.9-6.9-34.9s16.6-19.8 29.6-19.8H288c12.9 0 24.6 7.8 29.6 19.8s2.2 25.7-6.9 34.9l-128 128z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3">Deskripsi</th>
                                    <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600" @click="sortBy('price')">
                                        <div class="flex items-center justify-between">
                                            Harga
                                            <div class="sort-icons inline-flex flex-col ml-2">
                                                <svg class="w-2 h-2 fill-current opacity-50 sort-asc" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                                    <path d="M182.6 137.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8H288c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z"/>
                                                </svg>
                                                <svg class="w-2 h-2 fill-current opacity-50 sort-desc" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                                    <path d="M182.6 470.6c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-9.2-9.2-11.9-22.9-6.9-34.9s16.6-19.8 29.6-19.8H288c12.9 0 24.6 7.8 29.6 19.8s2.2 25.7-6.9 34.9l-128 128z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600" @click="sortBy('duration')">
                                        <div class="flex items-center justify-between">
                                            Durasi
                                            <div class="sort-icons inline-flex flex-col ml-2">
                                                <svg class="w-2 h-2 fill-current opacity-50 sort-asc" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                                    <path d="M182.6 137.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8H288c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z"/>
                                                </svg>
                                                <svg class="w-2 h-2 fill-current opacity-50 sort-desc" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                                    <path d="M182.6 470.6c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-9.2-9.2-11.9-22.9-6.9-34.9s16.6-19.8 29.6-19.8H288c12.9 0 24.6 7.8 29.6 19.8s2.2 25.7-6.9 34.9l-128 128z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600" @click="sortBy('status')">
                                        <div class="flex items-center justify-between">
                                            Status
                                            <div class="sort-icons inline-flex flex-col ml-2">
                                                <svg class="w-2 h-2 fill-current opacity-50 sort-asc" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                                    <path d="M182.6 137.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8H288c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z"/>
                                                </svg>
                                                <svg class="w-2 h-2 fill-current opacity-50 sort-desc" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                                    <path d="M182.6 470.6c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-9.2-9.2-11.9-22.9-6.9-34.9s16.6-19.8 29.6-19.8H288c12.9 0 24.6 7.8 29.6 19.8s2.2 25.7-6.9 34.9l-128 128z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="package in filteredPackages" :key="package.id">
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200 transform hover:scale-[1.002]">
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" x-text="package.name"></td>
                                        <td class="px-6 py-4 max-w-xs">
                                            <div class="text-gray-600 dark:text-gray-300 line-clamp-2" x-text="package.description"></div>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white" x-text="package.price"></td>
                                        <td class="px-6 py-4" x-text="package.duration + ' Bulan'"></td>
                                        <td class="px-6 py-4">
                                            <span :class="package.status === 'Aktif' ? 'bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300'" x-text="package.status"></span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <a :href="`/admin/packages/${package.id}/transactions`" class="text-blue-600 hover:text-blue-800">
                                                Lihat Transaksi
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 flex items-center justify-center gap-2">
                                        <a 
                                            :href="`{{ route('admin.packages.edit', '') }}/${package.id}`" 
                                            class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-all duration-300" 
                                            title="Edit"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>
                                            <button @click="toggleStatus(package)" class="p-2 text-yellow-600 hover:bg-yellow-100 rounded-lg transition-all duration-300" :title="package.status === 'Aktif' ? 'Nonaktifkan' : 'Aktifkan'">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path x-show="package.status === 'Aktif'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                    <path x-show="package.status === 'Nonaktif'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </button>
                                            <button @click="deletePackage(package)" class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition-all duration-300" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                                <tr x-show="filteredPackages.length === 0">
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center justify-center py-8">
                                            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-lg">Tidak ada paket ditemukan</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6 px-4">
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
                                <template x-for="page in Math.min(3, Math.ceil(paginatedPackages.length / 10))" :key="page">
                                    <li>
                                        <button 
                                            @click="currentPage = page" 
                                            :class="currentPage === page ? 'z-10 px-3 py-2 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:bg-gray-700 dark:text-white' : 'px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'"
                                            x-text="page"
                                        ></button>
                                    </li>
                                </template>
                                <li>
                                    <button 
                                        @click="currentPage = Math.min(Math.ceil(paginatedPackages.length / 10), currentPage + 1)" 
                                        :disabled="currentPage === Math.ceil(paginatedPackages.length / 10)" 
                                        :class="currentPage === Math.ceil(paginatedPackages.length / 10) ? 'cursor-not-allowed text-gray-300 dark:text-gray-600' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'" 
                                        class="block px-3 py-2 leading-tight bg-white border border-gray-300 rounded-r-lg dark:bg-gray-800 dark:border-gray-700"
                                    >
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

    <!-- Alpine.js Logic -->
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
                packages: @json($packages),
                
                get paginatedPackages() {
                    let result = [...this.packages];
                    
                    // Filter by search
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
                            return this.sortDirection === 'asc' ? priceA - priceB : priceB - priceA;
                        });
                    } else if (this.sortColumn === 'duration') {
                        result.sort((a, b) => {
                            return this.sortDirection === 'asc' ? a.duration - b.duration : b.duration - a.duration;
                        });
                    } else if (this.sortColumn === 'status') {
                        result.sort((a, b) => {
                            return this.sortDirection === 'asc' ? a.status.localeCompare(b.status) : b.status.localeCompare(a.status);
                        });
                    }
                    
                    return result;
                },
                
                get filteredPackages() {
                    const start = (this.currentPage - 1) * 10;
                    const end = start + 10;
                    return this.paginatedPackages.slice(start, end);
                },
                
                sortBy(column) {
                    if (this.sortColumn === column) {
                        this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
                    } else {
                        this.sortColumn = column;
                        this.sortDirection = 'asc';
                    }
                },
                
                async toggleStatus(packageItem) {
                    try {
                        const response = await fetch(`/admin/packages/${packageItem.id}/toggle`, {
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });
                        
                        if (response.ok) {
                            packageItem.status = packageItem.status === 'Aktif' ? 'Nonaktif' : 'Aktif';
                            this.successMessage = `Status paket ${packageItem.name} berhasil diperbarui!`;
                            this.showSuccess = true;
                            setTimeout(() => this.showSuccess = false, 3000);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    }
                },
                
                async deletePackage(packageItem) {
                    if (confirm(`Apakah Anda yakin ingin menghapus paket ${packageItem.name}?`)) {
                        try {
                            const response = await fetch(`/admin/packages/${packageItem.id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                }
                            });
                            
                            if (response.ok) {
                                this.packages = this.packages.filter(p => p.id !== packageItem.id);
                                this.successMessage = `Paket ${packageItem.name} berhasil dihapus!`;
                                this.showSuccess = true;
                                setTimeout(() => this.showSuccess = false, 3000);
                            }
                        } catch (error) {
                            console.error('Error:', error);
                        }
                    }
                },
                
                searchPackages() {
                    this.currentPage = 1;
                },
                
                filterPackages() {
                    this.currentPage = 1;
                }
            };
        }
    </script>
</x-app-layout>