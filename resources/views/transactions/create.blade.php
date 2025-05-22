<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="transactionForm" method="POST" action="{{ route('transactions.store') }}">
                        @csrf

                        <!-- Transaction Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <!-- User Selection -->
                            <div>
                                <label for="user_id" class="block mb-2 text-sm font-medium">Customer</label>
                                <select id="user_id" name="user_id" required
                                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                    <option value="">Select Customer</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- UMKM Selection -->
                            <div>
                                <label for="umkm_id" class="block mb-2 text-sm font-medium">UMKM</label>
                                <select id="umkm_id" name="umkm_id" required
                                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                    <option value="">Select UMKM</option>
                                    @foreach($umkms as $umkm)
                                    <option value="{{ $umkm->id }}" {{ old('umkm_id') == $umkm->id ? 'selected' : '' }}>
                                        {{ $umkm->nama_usaha }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Transaction Date -->
                            <div>
                                <label for="transaction_date" class="block mb-2 text-sm font-medium">Transaction Date</label>
                                <input type="datetime-local" id="transaction_date" name="transaction_date" required
                                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block mb-2 text-sm font-medium">Status</label>
                                <select id="status" name="status" required
                                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                    <option value="Pending">Pending</option>
                                    <option value="Paid">Paid</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>

                        <!-- Items Section -->
                        <div class="mb-8">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold">Rental Items</h3>
                                <button type="button" onclick="addItemRow()" 
                                    class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Item
                                </button>
                            </div>

                            <!-- Items Table -->
                            <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                                <table class="w-full" id="itemsTable">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-sm">Item</th>
                                            <th class="px-4 py-3 text-left text-sm">Quantity</th>
                                            <th class="px-4 py-3 text-left text-sm">Start Date</th>
                                            <th class="px-4 py-3 text-left text-sm">End Date</th>
                                            <th class="px-4 py-3 text-left text-sm">Price/Item</th>
                                            <th class="px-4 py-3 text-left text-sm">Subtotal</th>
                                            <th class="px-4 py-3 text-left text-sm">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        <!-- Initial empty row -->
                                        <tr class="item-row">
                                            <td class="px-4 py-3">
                                            <select name="details[0][inventory_id]" 
                                                class="inventory-select w-full" required
                                                onchange="updatePrice(this)">
                                                @foreach($inventories as $inventory)
                                                    <option value="{{ $inventory->id }}" 
                                                        data-price="{{ $inventory->harga }}">
                                                        {{ $inventory->nama_produk }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="number" name="details[0][quantity]" min="1" value="1" required
                                                    class="quantity-input w-20" onchange="calculateSubtotal(this)">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="datetime-local" name="details[0][rental_start]" required
                                                    class="date-input" onchange="calculateSubtotal(this)">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="datetime-local" name="details[0][rental_end]" required
                                                    class="date-input" onchange="calculateSubtotal(this)">
                                            </td>
                                            <td class="px-4 py-3 price-cell">
                                                Rp0
                                            </td>
                                            <td class="px-4 py-3 subtotal-cell">
                                                Rp0
                                            </td>
                                            <td class="px-4 py-3">
                                                <button type="button" onclick="removeItemRow(this)" 
                                                    class="text-red-600 hover:text-red-800">
                                                    ✕
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Total Section -->
                        <div class="flex justify-end mb-6">
                            <div class="text-xl font-semibold">
                                Total Amount: <span id="grandTotal">Rp0</span>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end gap-4">
                            <a href="{{ route('transactions.index') }}" 
                                class="px-6 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Create Transaction
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let rowIndex = 1;

        // Add new item row
        function addItemRow() {
            const newRow = document.querySelector('.item-row').cloneNode(true);
            const newIndex = rowIndex++;
            
            // Update all names and IDs
            newRow.querySelectorAll('[name]').forEach(element => {
                const name = element.getAttribute('name').replace('[0]', `[${newIndex}]`);
                element.setAttribute('name', name);
            });

            // Clear values
            newRow.querySelector('.rental-item-select').selectedIndex = 0;
            newRow.querySelector('.quantity-input').value = 1;
            newRow.querySelectorAll('.date-input').forEach(input => input.value = '');
            newRow.querySelector('.price-cell').textContent = 'Rp0';
            newRow.querySelector('.subtotal-cell').textContent = 'Rp0';

            // Add to table
            document.querySelector('#itemsTable tbody').appendChild(newRow);
            updateGrandTotal();
        }

        // Remove item row
        function removeItemRow(button) {
            if (document.querySelectorAll('.item-row').length > 1) {
                button.closest('tr').remove();
                updateGrandTotal();
            }
        }

        // Update price when item selected
        function updatePrice(select) {
            const price = select.options[select.selectedIndex].dataset.price || 0;
            const row = select.closest('tr');
            row.querySelector('.price-cell').textContent = `Rp${parseFloat(price).toLocaleString()}`;
            calculateSubtotal(select);
        }

        // Calculate subtotal for a row
        function calculateSubtotal(input) {
            const row = input.closest('tr');
            const price = parseFloat(row.querySelector('.price-cell').textContent.replace(/[^0-9.]/g, '') || 0);
            const quantity = parseInt(row.querySelector('.quantity-input').value) || 0;
            const startDate = new Date(row.querySelector('[name$="[rental_start]"]').value);
            const endDate = new Date(row.querySelector('[name$="[rental_end]"]').value);
            
            // Calculate days
            const days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) || 0;
            
            const subtotal = price * quantity * days;
            row.querySelector('.subtotal-cell').textContent = `Rp${subtotal.toLocaleString()}`;
            row.querySelector('[name$="[sub_total]"]').value = subtotal;
            
            updateGrandTotal();
        }

        // Update grand total
        function updateGrandTotal() {
            let total = 0;
            document.querySelectorAll('.subtotal-cell').forEach(cell => {
                total += parseFloat(cell.textContent.replace(/[^0-9.]/g, '')) || 0;
            });
            document.getElementById('grandTotal').textContent = `Rp${total.toLocaleString()}`;
        }

        // Get rental items when UMKM changes
        document.getElementById('umkm_id').addEventListener('change', function() {
            const umkmId = this.value;
            fetch(`/transactions/get-inventories/${umkmId}`)
                .then(response => response.json())
                .then(items => {
                    const itemSelects = document.querySelectorAll('.rental-item-select');
                    itemSelects.forEach(select => {
                        select.innerHTML = '<option value="">Select Item</option>' + 
                            items.map(item => 
                                `<option value="${item.inventory_id}" data-price="${item.harga}">
                                    ${item.nama_produk}
                                </option>`
                            ).join('');
                    });
                });
        });

        // Initial event listeners
        document.querySelectorAll('.quantity-input, .date-input').forEach(input => {
            input.addEventListener('change', () => calculateSubtotal(input));
        });
    </script>

    <style>
        .rental-item-select, .quantity-input, .date-input {
            @apply bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white;
        }
        
        #itemsTable th {
            @apply bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100;
        }
        
        #itemsTable td {
            @apply bg-white dark:bg-gray-800;
        }
    </style>
</x-app-layout>