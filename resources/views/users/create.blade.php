<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-6">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input 
                                id="name" 
                                name="name" 
                                type="text" 
                                class="mt-1 block w-full" 
                                :value="old('name')" 
                                required 
                                autofocus 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <!-- Email -->
                        <div class="mb-6">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input 
                                id="email" 
                                name="email" 
                                type="email" 
                                class="mt-1 block w-full" 
                                :value="old('email')" 
                                required 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <!-- Role Dropdown -->
                        <div class="mb-6">
                            <x-input-label for="role" :value="__('Role')" />
                            <select 
                                id="role" 
                                name="role" 
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required
                            >
                                <option value="" disabled selected>Select Role</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="umkm" {{ old('role') == 'umkm' ? 'selected' : '' }}>UMKM</option>
                                <option value="public" {{ old('role') == 'public' ? 'selected' : '' }}>Public</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('role')" />
                        </div>

                        <!-- Status Dropdown -->
                        <div class="mb-6">
                            <x-input-label for="status" :value="__('Status')" />
                            <select 
                                id="status" 
                                name="status" 
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required
                            >
                                <option value="" disabled selected>Select Status</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>active</option>
                                <option value="banned" {{ old('status') == 'banned' ? 'selected' : '' }}>banned</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>

                        <!-- Password -->
                        <div class="mb-6">
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input 
                                id="password" 
                                name="password" 
                                type="password" 
                                class="mt-1 block w-full" 
                                required 
                                autocomplete="new-password" 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-6">
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                type="password" 
                                class="mt-1 block w-full" 
                                required 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <x-danger-link-button :href="route('users.index')">
                                {{ __('Cancel') }}
                            </x-danger-link-button>
                            
                            <x-primary-button>
                                {{ __('Create User') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>