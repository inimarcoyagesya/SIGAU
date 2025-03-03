<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl transition-all duration-300">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Header dengan Fitur Pencarian dan Filter -->
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
                                placeholder="Search users..."
                                onkeyup="searchTable()"
                            >
                        </div>

                        <!-- Tambah User Button -->
                        <a href="{{ route('users.create') }}" class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 text-white rounded-lg transition-all duration-300 transform hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Add New</span>
                        </a>
                    </div>

                    <!-- Tabel User -->
                    <div class="relative overflow-x-auto rounded-xl shadow-lg transition-all duration-300">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="userTable">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                    <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600" onclick="sortTable(0)">
                                        <div class="flex items-center justify-between">
                                            NO
                                            <div class="sort-icons inline-flex flex-col ml-2">
                                                <svg class="w-2 h-2 fill-current opacity-50 sort-asc" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M182.6 137.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8H288c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z"/></svg>
                                                <svg class="w-2 h-2 fill-current opacity-50 sort-desc" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M182.6 470.6c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-9.2-9.2-11.9-22.9-6.9-34.9s16.6-19.8 29.6-19.8H288c12.9 0 24.6 7.8 29.6 19.8s2.2 25.7-6.9 34.9l-128 128z"/></svg>
                                            </div>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600" onclick="sortTable(1)">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600" onclick="sortTable(2)">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600" onclick="sortTable(3)">
                                        Role
                                    </th>
                                    <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600" onclick="sortTable(4)">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200 transform hover:scale-[1.002]">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ ++$i }}
                                    </td>
                                    <td class="px-6 py-4">{{ $user->name }}</td>
                                    <td class="px-6 py-4">{{ $user->email }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-sm 
                                            {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300' : 
                                            ($user->role == 'umkm' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 
                                            'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300') }}">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-sm 
                                            {{ $user->status == 'verified' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 
                                            ($user->status == 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : 
                                            'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300') }}">
                                            {{ $user->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 flex items-center justify-center gap-2">
                                        <a href="{{ route('users.edit', $user->id) }}" class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-all duration-300" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition-all duration-300" title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center justify-center py-8">
                                            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-lg">No users found</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6 px-4">
                        {{ $users->links() }}
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
            const table = document.getElementById('userTable');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td');
                let found = false;
                
                for (let j = 0; j < td.length - 1; j++) { // Exclude action column
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
            const table = document.getElementById('userTable');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            
            sortDirection = !sortDirection;

            rows.sort((a, b) => {
                const aValue = a.getElementsByTagName('td')[column].textContent;
                const bValue = b.getElementsByTagName('td')[column].textContent;
                
                if (column === 0) { // Numeric sorting for ID
                    return sortDirection ? aValue - bValue : bValue - aValue;
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

    <style>
        /* Animasi dan Transisi */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        .sort-icons {
            opacity: 0.5;
            transition: opacity 0.3s ease;
        }

        th:hover .sort-icons {
            opacity: 1;
        }

        .hover\:scale-105:hover {
            transform: scale(1.05);
        }

        .hover\:scale-\[1\.002\]:hover {
            transform: scale(1.002);
        }

        /* Warna Tema GIS */
        .bg-gradient-to-r {
            background-image: linear-gradient(to right, #3B82F6, #10B981);
        }
    </style>
</x-app-layout>