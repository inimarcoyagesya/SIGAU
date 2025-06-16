<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.transactions.store') }}">
                        @csrf

                        <!-- User -->
                        <div class="mb-6">
                            <x-input-label for="user_id" :value="__('User')" />
                            <select 
                                id="user_id" 
                                name="user_id" 
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required
                            >
                                <option value="" disabled selected>Select User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                        </div>

                        <!-- Package -->
                        <div class="mb-6">
                            <x-input-label for="package_id" :value="__('Package')" />
                            <select 
                                id="package_id" 
                                name="package_id" 
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required
                            >
                                <option value="" disabled selected>Select Package</option>
                                @foreach($packages as $package)
                                    <option value="{{ $package->id }}" {{ old('package_id') == $package->id ? 'selected' : '' }}>
                                        {{ $package->name }} (Rp {{ number_format($package->price, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('package_id')" />
                        </div>

                        <!-- Amount -->
                        <div class="mb-6">
                            <x-input-label for="amount" :value="__('Amount')" />
                            <x-text-input 
                                id="amount" 
                                name="amount" 
                                type="number" 
                                step="0.01" 
                                class="mt-1 block w-full" 
                                :value="old('amount')" 
                                required 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Masukkan jumlah pembayaran</p>
                        </div>

                        <!-- Status -->
                        <div class="mb-6">
                            <x-input-label for="status" :value="__('Status')" />
                            <select 
                                id="status" 
                                name="status" 
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required
                            >
                                <option value="" disabled selected>Select Status</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="success" {{ old('status') == 'success' ? 'selected' : '' }}>Success</option>
                                <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>

                        <!-- Payment Date -->
                        <div class="mb-6">
                            <x-input-label for="paid_at" :value="__('Payment Date')" />
                            <x-text-input 
                                id="paid_at" 
                                name="paid_at" 
                                type="datetime-local" 
                                class="mt-1 block w-full" 
                                :value="old('paid_at')" 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('paid_at')" />
                        </div>

                        <!-- Submit -->
                        <div class="flex items-center justify-end gap-4">
                            <x-danger-link-button :href="route('admin.transactions.index')">
                                {{ __('Cancel') }}
                            </x-danger-link-button>
                            
                            <x-primary-button>
                                {{ __('Create Transaction') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>