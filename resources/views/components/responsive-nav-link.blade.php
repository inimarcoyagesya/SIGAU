@props(['active' => false])

@php
$classes = ($active ?? false)
            ? 'block px-4 py-2 text-sm text-white bg-blue-700/20 rounded-lg transition-colors duration-200'
            : 'block px-4 py-2 text-sm text-white hover:bg-blue-700/20 rounded-lg transition-colors duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>