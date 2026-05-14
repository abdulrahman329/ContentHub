@props([
    'variant' => 'primary'
])

@php
$classes = match($variant) {
    
    'primary' => 'bg-blue-600 text-white hover:bg-blue-800',

    'danger' => 'text-red-500 hover:text-red-700 font-semibold',

    'warning' => 'text-yellow-500 hover:text-yellow-700 ',

    'restore' => 'text-green-400 hover:text-green-600 font-semibold',

    'trash' => 'bg-gray-600 hover:bg-gray-900 text-white font-bold px-5 py-2  shadow ',

    'create' => 'bg-indigo-600 text-white py-3 px-6 rounded-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-600 w-full transition',

    'update' => 'bg-yellow-500 text-black hover:bg-yellow-700 px-6 py-2 rounded font-bold ',

    'secondary' => 'bg-gray-600 text-white hover:bg-gray-800',

    'link' => 'text-blue-500 hover:text-blue-700 underline',

    'back' => 'text-lg text-white bg-blue-600 hover:bg-blue-800 hover:scale-105 duration-200 px-6 py-2 font-semibold',
    
    default => 'bg-blue-600 text-white hover:bg-blue-800',
};
@endphp

<button {{ $attributes->merge([
    'class' => $classes . ' rounded-md transition'
]) }}>
    {{ $slot }}
</button>
