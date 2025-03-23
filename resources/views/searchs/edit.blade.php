<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update Search') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if ($errors->any())
                        <div class="bg-red-100 text-red-700 p-4 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('searchs.update', $search->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Keyword -->
                        <div class="mb-6">
                            <x-input-label for="keyword" :value="__('Keyword')" />
                            <x-text-input 
                                id="keyword" 
                                name="keyword" 
                                type="text" 
                                class="mt-1 block w-full" 
                                :value="old('keyword', $search->keyword)" 
                                required 
                                autofocus 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('keyword')" />
                        </div>

                        <!-- Kategori Filter -->
                        <div class="mb-6">
                            <x-input-label for="kategori_filter" :value="__('Kategori Filter')" />
                            <x-text-input 
                                id="kategori_filter" 
                                name="kategori_filter" 
                                type="text" 
                                class="mt-1 block w-full" 
                                :value="old('kategori_filter', $search->kategori_filter)" 
                                required 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('kategori_filter')" />
                        </div>

                        <!-- Radius -->
                        <div class="mb-6">
                            <x-input-label for="radius" :value="__('Radius (meter)')" />
                            <x-text-input 
                                id="radius" 
                                name="radius" 
                                type="number" 
                                class="mt-1 block w-full" 
                                :value="old('radius', $search->radius)" 
                                required 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('radius')" />
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <x-danger-link-button :href="route('searchs.index')">
                                {{ __('Cancel') }}
                            </x-danger-link-button>
                            
                            <x-primary-button>
                                {{ __('Save Changes') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
