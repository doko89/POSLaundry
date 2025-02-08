@props(['active'])

@php
$classes = ($active ?? false)
    ? 'flex items-center px-4 py-2 text-sm font-medium text-white bg-primary-700 rounded-md'
    : 'flex items-center px-4 py-2 text-sm font-medium text-white hover:bg-primary-600 rounded-md';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a> 