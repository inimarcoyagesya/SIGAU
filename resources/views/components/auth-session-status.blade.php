@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'p-4 rounded-lg mb-6 text-sm']) }}>
        {{ $status }}
    </div>
@endif