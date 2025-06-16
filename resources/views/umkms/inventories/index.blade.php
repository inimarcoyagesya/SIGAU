<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Inventori') }}
        </h2>
    </x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <a href="{{ route('umkm.inventories.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-plus mr-2"></i> Tambah Produk
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Produk
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stok
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Harga
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($inventories as $inventory)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($inventory->gambar)
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $inventory->gambar) }}" alt="{{ $inventory->nama_produk }}">
                                        </div>
                                        @endif
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $inventory->nama_produk }}</div>
                                            <div class="text-sm text-gray-500">{{ $inventory->satuan }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $inventory->stok }} {{ $inventory->satuan }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">Rp {{ number_format($inventory->harga, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $inventory->status_warna }}-100 text-{{ $inventory->status_warna }}-800">
                                        {{ ucfirst($inventory->status_stok) }}
                                    </span>
                                    @if($inventory->expired_date)
                                    <div class="text-xs text-gray-500 mt-1">
                                        Exp: {{ $inventory->expired_date->format('d M Y') }}
                                    </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('umkm.inventories.edit', $inventory->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('umkm.inventories.destroy', $inventory->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Belum ada produk. <a href="{{ route('umkm.inventories.create') }}" class="text-blue-600 hover:underline">Tambahkan produk pertama</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($inventories->hasPages())
                <div class="mt-6">
                    {{ $inventories->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</x-app-layout>