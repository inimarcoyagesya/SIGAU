<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Inventory Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl p-6 transition-all">

                <!-- FILTER CONTROLS -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <!-- Start Date -->
                    <div>
                        <label for="startDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                        <input
                            type="date"
                            id="startDate"
                            class="mt-1 block w-full p-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        >
                    </div>
                    <!-- End Date -->
                    <div>
                        <label for="endDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date</label>
                        <input
                            type="date"
                            id="endDate"
                            class="mt-1 block w-full p-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        >
                    </div>
                    <!-- UMKM Combo Box -->
                    <div>
                        <label for="umkmSelect" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih UMKM</label>
                        <select
                            id="umkmSelect"
                            class="mt-1 block w-full p-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        >
                            <option value="">-- Semua UMKM --</option>
                            @foreach($umkms as $id => $nama)
                                <option value="{{ $id }}">{{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Process Button -->
                    <div class="flex items-end">
                        <button
                            id="btnProcess"
                            type="button"
                            class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all"
                        >Process</button>
                    </div>
                </div>

                <!-- TOMBOL CETAK / TAMBAH TETAP DI SINI -->
                <div class="flex justify-between mb-4">
                    <form id="pdfForm" method="POST" action="{{ route('inventories.selected-pdf') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg">
                            Cetak Selected
                        </button>
                    </form>
                    <a href="{{ route('inventories2.create') }}"
                        class="flex items-center gap-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg">
                        Tambah Baru
                    </a>
                </div>

                <!-- TABLE (Awalnya hidden) -->
                <div id="tableWrapper" class="hidden relative overflow-x-auto rounded-xl shadow-lg transition-all">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="inventoryTable">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3"><input type="checkbox" id="selectAll"></th>
                                <th class="px-6 py-3">NO</th>
                                <th class="px-6 py-3">Nama Produk</th>
                                <th class="px-6 py-3">UMKM</th>
                                <th class="px-6 py-3">Harga</th>
                                <th class="px-6 py-3">Stok</th>
                                <th class="px-6 py-3">Supplier</th>
                                <th class="px-6 py-3">Expired Date</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Row akan di‐inject oleh JS -->
                        </tbody>
                    </table>
                    <div class="mt-4 px-4">
                        <!-- pagination jika diperlukan -->
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Simpan data original (dari server) jika nanti pakai AJAX,
        // atau langsung render variable Blade ke JS.
        let inventories = @json([]); // Kosong dulu, nanti diisi via AJAX

        // Event Process: fetch/filter dan render
        document.getElementById('btnProcess').addEventListener('click', function() {
            const start = document.getElementById('startDate').value;
            const end   = document.getElementById('endDate').value;
            const umkm  = document.getElementById('umkmSelect').value;

            // Contoh: fetch data via AJAX (pake Axios atau fetch)
            // endpoint harus menerima query params: start, end, umkm
            fetch(`{{ url('inventories2/filter') }}?start=${start}&end=${end}&umkm=${umkm}`)
                .then(res => res.json())
                .then(data => {
                    inventories = data;       // Array of inventory objects
                    renderTableRows(inventories);
                });
        });

        // Render function
        function renderTableRows(items) {
            const tbody = document.querySelector('#inventoryTable tbody');
            tbody.innerHTML = ''; // reset

            if (items.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            Tidak ada data sesuai filter.
                        </td>
                    </tr>`;
            } else {
                items.forEach((inv, idx) => {
                    const tr = document.createElement('tr');
                    tr.className = 'bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600';
                    tr.innerHTML = `
                        <td class="px-6 py-4"><input type="checkbox" class="item-checkbox" value="${inv.id}"></td>
                        <td class="px-6 py-4">${idx+1}</td>
                        <td class="px-6 py-4">${inv.nama_produk}</td>
                        <td class="px-6 py-4">${inv.umkm.nama_usaha}</td>
                        <td class="px-6 py-4">Rp ${Number(inv.harga).toLocaleString('id-ID', {minimumFractionDigits:2})}</td>
                        <td class="px-6 py-4">${inv.stok}</td>
                        <td class="px-6 py-4">${inv.supplier}</td>
                        <td class="px-6 py-4">${inv.expired_date_formatted}</td>
                        <td class="px-6 py-4 text-center">
                            <a href="/inventories2/${inv.id}/edit" class="text-yellow-500 mr-2">Edit</a>
                            <form action="/inventories2/${inv.id}" method="POST" class="inline">@method('DELETE')@csrf
                                <button type="submit" onclick="return confirm('Yakin?')" class="text-red-600">Hapus</button>
                            </form>
                        </td>`;
                    tbody.appendChild(tr);
                });
            }

            // Tampilkan table
            document.getElementById('tableWrapper').classList.remove('hidden');
            
            // reinit selectAll listener
            document.getElementById('selectAll').addEventListener('click', e => {
                document.querySelectorAll('.item-checkbox')
                    .forEach(chk => chk.checked = e.target.checked);
            });
        }
    </script>
</x-app-layout>
