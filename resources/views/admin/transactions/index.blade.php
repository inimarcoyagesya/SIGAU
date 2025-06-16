<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            {{ __('Transaksi Langganan') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="transactionData()">
        <!-- Form Filter Tanggal -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6">
                <div class="flex flex-col md:flex-row gap-4 mb-6">
                    <div class="w-full md:w-64">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">Tanggal Mulai</label>
                        <input type="date" x-model="startDate" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div class="w-full md:w-64">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">Tanggal Akhir</label>
                        <input type="date" x-model="endDate" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div class="flex items-end gap-2">
                        <button @click="generateReport('view')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <i class="fas fa-eye"></i> Lihat
                        </button>
                        <button @click="generateReport('pdf')" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            <i class="fas fa-file-pdf"></i> PDF
                        </button>
                        <button @click="generateReport('excel')" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            <i class="fas fa-file-excel"></i> Excel
                        </button>
                        <a href="{{ route('admin.transactions.create') }}" class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 text-white rounded-lg transition-all duration-300 transform hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Add New</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Transaksi -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl overflow-hidden">
                <div class="p-6">
                    <template x-if="reportData.length > 0">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left">ID Transaksi</th>
                                    <th class="px-6 py-3 text-left">Nama Pengguna</th>
                                    <th class="px-6 py-3 text-left">Paket</th>
                                    <th class="px-6 py-3 text-left">Harga</th>
                                    <th class="px-6 py-3 text-left">Status</th>
                                    <th class="px-6 py-3 text-left">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <template x-for="item in reportData" :key="item.id">
                                    <tr>
                                        <td x-text="item.transaction_id" class="px-6 py-4"></td>
                                        <td x-text="item.user.name" class="px-6 py-4"></td>
                                        <td x-text="item.package.name" class="px-6 py-4"></td>
                                        <td x-text="'Rp ' + item.amount.toLocaleString()" class="px-6 py-4"></td>
                                        <td class="px-6 py-4">
                                            <span :class="{
                                                'bg-green-100 text-green-800': item.status === 'success',
                                                'bg-yellow-100 text-yellow-800': item.status === 'pending',
                                                'bg-red-100 text-red-800': item.status === 'failed'
                                            }" class="px-2 py-1 rounded text-xs font-medium" x-text="item.status"></span>
                                        </td>
                                        <td x-text="item.paid_at || item.created_at" class="px-6 py-4"></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </template>
                    <template x-if="reportData.length === 0 && reportGenerated">
                        <div class="text-center py-12">
                            <i class="fas fa-exchange-alt text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-500 dark:text-gray-400">Tidak ada transaksi ditemukan</p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <script>
    function transactionData() {
        return {
            startDate: '',
            endDate: '',
            reportData: [],
            reportGenerated: false,

            generateReport(type) {
                if (!this.startDate || !this.endDate) {
                    alert('Silakan pilih tanggal mulai dan akhir');
                    return;
                }

                const baseRoute = "{{ route('admin.transactions.report') }}";
                
                if (type === 'view') {
                    // Tampilkan di web
                    fetch(`${baseRoute}?start_date=${this.startDate}&end_date=${this.endDate}`)
                        .then(res => res.json())
                        .then(data => {
                            this.reportData = data;
                            this.reportGenerated = true;
                        });
                } else if (type === 'pdf') {
                    // Download PDF
                    window.open(`${baseRoute}/pdf?start_date=${this.startDate}&end_date=${this.endDate}`);
                } else if (type === 'excel') {
                    // Download Excel
                    window.open(`${baseRoute}/excel?start_date=${this.startDate}&end_date=${this.endDate}`);
                }
            }
        }
    }
</script>
</x-app-layout>