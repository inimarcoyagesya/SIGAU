@props(['message'])
<div {{ $attributes->merge(['class' => 'flex items-center p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-400 transition-all duration-300']) }}>
    <i class="fas fa-exclamation-triangle mr-3 text-lg"></i>
    <div>
        {{ $message }}
    </div>
    <button type="button" @click="$el.parentElement.remove()" class="ml-auto -mx-1.5 -my-1.5 text-yellow-500 hover:text-yellow-600">
        <i class="fas fa-times"></i>
    </button>
</div>