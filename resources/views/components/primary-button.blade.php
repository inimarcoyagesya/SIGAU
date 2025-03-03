@props(['disabled' => false])

<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md bg-sky-400 font-semibold text-white uppercase tracking-widest transition ease-in-out duration-150' . ($disabled ? ' opacity-75 cursor-not-allowed' : '')
]) }}>
    {{ $slot }}
</button>