@props(['message'])

<div 
    x-data="{ show: true }" 
    x-show="show" 
    x-init="setTimeout(() => show = false, 3000)" 
    x-transition 
    {{ $attributes->merge(['class' => 'flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 transition-all duration-300']) }}
>
    <i class="fas fa-check-circle mr-3 text-lg"></i>
    <div>
        {{ $message }}
    </div>
    <button type="button" @click="show = false" class="ml-auto -mx-1.5 -my-1.5 text-green-500 hover:text-green-600">
        <i class="fas fa-times"></i>
    </button>
</div>
