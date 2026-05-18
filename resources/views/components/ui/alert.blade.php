@props([
    'type' => 'success'
])

@php
$classes = match($type) {
    'success' => 'mb-4 p-4 bg-green-700 text-white',
    'error' => 'bg-red-600 text-white',
    'warning' => 'bg-yellow-500 text-black',
    default => 'bg-gray-600 text-white'
};
@endphp

<div {{ $attributes->merge([
    'class' => "{$classes} p-4 rounded-lg shadow-lg"
]) }}>
    {{ $slot }}
</div>