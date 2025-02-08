@props([
    'type' => 'button',
    'variant' => 'primary'
])

@php
$variantClasses = [
    'primary' => 'bg-primary-500 hover:bg-primary-600 text-white',
    'secondary' => 'bg-secondary-500 hover:bg-secondary-600 text-white',
    'danger' => 'bg-red-500 hover:bg-red-600 text-white',
];

$classes = 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150 ' . $variantClasses[$variant];
@endphp

<button {{ $attributes->merge(['type' => $type, 'class' => $classes]) }}>
    {{ $slot }}
</button> 