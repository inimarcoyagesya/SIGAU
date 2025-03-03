@props(['active' => false])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 py-2 bg-blue-700/20 text-white rounded-lg font-medium transition-colors duration-200'
            : 'inline-flex items-center px-4 py-2 text-white hover:bg-blue-700/20 rounded-lg font-medium transition-colors duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>