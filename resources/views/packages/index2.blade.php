<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Pilih Paket Langganan</h2>
    </x-slot>

    <div class="py-12" x-data="packageData()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <template x-for="package in packages" :key="package.id">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-transform hover:scale-105">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white" x-text="package.name"></h3>
                            <p class="mt-2 text-gray-600 dark:text-gray-300" x-text="package.description"></p>
                            <div class="mt-4 text-2xl font-semibold text-blue-600" x-text="package.price"></div>
                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400" x-text="package.duration + ' Bulan'"></span>
                                <button 
                                    @click="confirmPurchase(package)"
                                    class="px-4 py-2 bg-gradient-to-r from-green-500 to-blue-600 text-white rounded-lg hover:from-green-600 hover:to-blue-700"
                                >Berlangganan</button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <script>
        function packageData() {
            return {
                packages: @json($packages),
                confirmPurchase(package) {
                    if (confirm(`Apakah Anda yakin ingin berlangganan ${package.name} dengan harga ${package.price}?`)) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/umkm/packages/${package.id}/confirm`;
                        form.innerHTML = `@csrf`;
                        document.body.appendChild(form);
                        form.submit();
                    }
                }
            };
        }
    </script>
</x-app-layout>