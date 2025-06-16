<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Transaction') }}
        </h2>
    </x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <a href="{{ route('umkm.transactions.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-plus mr-2"></i> Transaksi Baru
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
                                    Nama Transaksi
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jenis
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jumlah
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($transactions as $transaction)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $transaction->nama_transaksi }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $transaction->jenis === 'pemasukan' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $transaction->jenis === 'pemasukan' ? 'Pemasukan' : 'Pengeluaran' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 {{ $transaction->jenis === 'pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                                        Rp {{ number_format($transaction->jumlah, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $transaction->status == 'success' ? 'bg-green-100 text-green-800' : 
                                           ($transaction->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $transaction->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $transaction->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('umkm.transactions.show', $transaction->id) }}" class="text-blue-600 hover:text-blue-900 mr-3"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('umkm.transactions.edit', $transaction->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('umkm.transactions.destroy', $transaction->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Belum ada transaksi. <a href="{{ route('umkm.transactions.create') }}" class="text-blue-600 hover:underline">Buat transaksi pertama</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($transactions->hasPages())
                <div class="mt-6">
                    {{ $transactions->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</x-app-layout>