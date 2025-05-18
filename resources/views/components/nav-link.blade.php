@props(['active' => false])

@php
$classes = $active
    ? 'inline-flex items-center px-1 pt-1 border-b-2 border-mindcare-blue text-sm font-medium text-gray-900'
    : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>