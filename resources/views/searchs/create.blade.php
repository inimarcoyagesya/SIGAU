<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Search') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('searchs.store') }}">
                        @csrf

                        <!-- Keyword -->
                        <div class="mb-6">
                            <x-input-label for="keyword" :value="__('keyword')" />
                            <x-text-input 
                                id="keyword" 
                                name="keyword" 
                                type="text" 
                                class="mt-1 block w-full" 
                                :value="old('keyword')" 
                                required 
                                autofocus 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('keyword')" />
                        </div>

                        <!-- Kategori_filter -->
                        <div class="mb-6">
                            <x-input-label for="kategori_filter" :value="__('kategori_filter')" />
                            <x-text-input 
                                id="kategori_filter" 
                                name="kategori_filter" 
                                type="kategori_filter" 
                                class="mt-1 block w-full" 
                                :value="old('kategori_filter')" 
                                required 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('kategori_filter')" />
                        </div>

                        <!-- Radius -->
                        <div class="mb-6">
                            <x-input-label for="radius" :value="__('radius')" />
                            <x-text-input 
                                id="radius" 
                                name="radius" 
                                type="radius" 
                                class="mt-1 block w-full" 
                                :value="old('radius')" 
                                required 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('radius')" />
                        </div>

                        <!-- search_id -->
                        <div class="mb-6">
                            <x-input-label for="search_id" :value="__('search_id')" />
                            <x-text-input 
                                id="search_id" 
                                name="search_id" 
                                type="search_id" 
                                class="mt-1 block w-full" 
                                :value="old('search_id')" 
                                required 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('search_id')" />
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <x-danger-link-button :href="route('searchs.index')">
                                {{ __('Cancel') }}
                            </x-danger-link-button>
                            
                            <x-primary-button>
                                {{ __('Create Search') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>