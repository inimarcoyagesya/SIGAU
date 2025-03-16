@props(['message'])

<div 
    x-data="{ show: true }" 
    x-show="show" 
    x-transition 
    {{ $attributes->merge(['class' => 'flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 transition-all duration-300']) }}
>
    <i class="fas fa-exclamation-circle mr-3 text-lg"></i>
    <div>
        {{ $message }}
    </div>
    <button type="button" @click="show = false" class="ml-auto -mx-1.5 -my-1.5 text-red-500 hover:text-red-600">
        <i class="fas fa-times"></i>
    </button>
</div>
