<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Inventory Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl transition-all duration-300">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Header dengan Fitur Pencarian -->
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
                        <!-- Search Box -->
                        <div class="w-full md:w-96 relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                id="searchInput"
                                class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-300"
                                placeholder="Cari Produk..."
                                onkeyup="searchTable()"
                            >
                        </div>

                        <!-- Tambah Inventory Button -->
                        <a href="{{ route('inventories.create') }}" class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 text-white rounded-lg transition-all duration-300 transform hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Tambah Baru</span>
                        </a>
                    </div>

                    <!-- Tabel Inventory -->
                    <div class="relative overflow-x-auto rounded-xl shadow-lg transition-all duration-300">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="inventoryTable">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                    <th scope="col" class="px-6 py-3 cursor-pointer" onclick="sortTable(0)">NO</th>
                                    <th scope="col" class="px-6 py-3 cursor-pointer" onclick="sortTable(1)">Nama Produk</th>
                                    <th scope="col" class="px-6 py-3 cursor-pointer" onclick="sortTable(2)">UMKM</th>
                                    <th scope="col" class="px-6 py-3 cursor-pointer" onclick="sortTable(3)">Harga</th>
                                    <th scope="col" class="px-6 py-3 cursor-pointer" onclick="sortTable(4)">Stok</th>
                                    <th scope="col" class="px-6 py-3 cursor-pointer" onclick="sortTable(5)">Supplier</th>
                                    <th scope="col" class="px-6 py-3 cursor-pointer" onclick="sortTable(6)">Expired Date</th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($inventories as $inventory)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200 transform hover:scale-[1.002]">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ +$i }}
                                    </td>
                                    <td class="px-6 py-4">{{ $inventory->nama_produk }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-sm bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300">
                                            {{ $inventory->umkm->nama_usaha ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">Rp {{ number_format($inventory->harga, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-sm {{ $inventory->stok < 10 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }} dark:bg-gray-700">
                                            {{ $inventory->stok }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">{{ $inventory->supplier }}</td>
                                    <td class="px-6 py-4">
                                        {{ $inventory->expired_date ? \Carbon\Carbon::parse($inventory->expired_date)->format('d/m/Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 flex items-center justify-center gap-2">
                                        <a href="{{ route('inventories.edit', $inventory->id) }}" class="p-2 text-yellow-600 hover:bg-yellow-100 rounded-lg transition-all duration-300" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('inventories.destroy', $inventory->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition-all duration-300" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center justify-center py-8">
                                            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-lg">Tidak ada data produk</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6 px-4">
                        {{ $inventories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi Pencarian
        function searchTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toUpperCase();
            const table = document.getElementById('inventoryTable');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td');
                let found = false;
                
                for (let j = 1; j < td.length - 1; j++) {
                    if (td[j]) {
                        const txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }
                
                tr[i].style.display = found ? '' : 'none';
            }
        }

        // Fungsi Sorting
        let sortDirection = true;
        function sortTable(column) {
            const table = document.getElementById('inventoryTable');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            
            sortDirection = !sortDirection;

            rows.sort((a, b) => {
                const aValue = a.getElementsByTagName('td')[column].textContent;
                const bValue = b.getElementsByTagName('td')[column].textContent;
                
                if (column === 0 || column === 3 || column === 4) { // Numeric columns
                    const numA = parseFloat(aValue.replace(/[^\d]/g, ''));
                    const numB = parseFloat(bValue.replace(/[^\d]/g, ''));
                    return sortDirection ? numA - numB : numB - numA;
                } else if (column === 6) { // Date sorting
                    const dateA = new Date(aValue.split('/').reverse().join('-'));
                    const dateB = new Date(bValue.split('/').reverse().join('-'));
                    return sortDirection ? dateA - dateB : dateB - dateA;
                } else { // String sorting
                    return sortDirection ? 
                        aValue.localeCompare(bValue) : 
                        bValue.localeCompare(aValue);
                }
            });

            while (tbody.firstChild) tbody.removeChild(tbody.firstChild);
            rows.forEach(row => tbody.appendChild(row));
        }
    </script>
</x-app-layout>