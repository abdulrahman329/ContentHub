@props([
    'variant' => 'primary',
    'href' => null
])

@php
$classes = match($variant) {

    'danger' => '
        text-red-500 hover:text-red-700 font-semibold
        dark:text-red-400 dark:hover:text-red-300
    ',

    'warning' => '
        text-yellow-600 hover:text-yellow-800
        dark:text-yellow-400 dark:hover:text-yellow-300
    ',

    'restore' => '
        text-green-600 hover:text-green-800 font-semibold
        dark:text-green-400 dark:hover:text-green-300
    ',

    'comment' => 
        'shrink-0 px-3 py-1 text-xs rounded
        bg-blue-600 hover:bg-blue-700
        text-white transition',

    'create' => ' 
        px-6 py-3 rounded-xl font-semibold text-sm transition-all duration-200
        bg-blue-100 text-blue-700 border border-blue-300
        hover:bg-blue-200
        dark:bg-blue-500/20 dark:text-blue-300 dark:border-blue-500/40
        dark:hover:bg-blue-500/30
    ',

    'update' => ' 
        px-6 py-3 rounded-xl font-semibold text-sm transition-all duration-200
        bg-yellow-100 text-yellow-700 border border-yellow-300
        hover:bg-yellow-200
        dark:bg-yellow-500/20 dark:text-yellow-300 dark:border-yellow-500/40
        dark:hover:bg-yellow-500/30
    ',

    'show-edit' => '
        inline-flex items-center justify-center text-sm font-bold uppercase tracking-wide

        text-yellow-700 dark:text-yellow-300

        border border-yellow-400/40 dark:border-yellow-500/40

        bg-white/60 dark:bg-black/30 backdrop-blur

        px-3 py-2 rounded-full

        hover:bg-yellow-500 hover:text-black

        dark:hover:bg-yellow-500 dark:hover:text-white

        hover:border-yellow-400

        transition-all duration-300
    ',

    'show-delete' => '
        inline-flex items-center justify-center text-sm font-bold uppercase tracking-wide

        text-red-600 dark:text-red-300

        border border-red-400/40 dark:border-red-500/40

        bg-white/60 dark:bg-black/30 backdrop-blur

        px-3 py-2 rounded-full

        hover:bg-red-500 hover:text-black

        dark:hover:bg-red-500 dark:hover:text-white

        hover:border-red-400

        transition-all duration-300
    ',

    'back' => '
        inline-flex items-center justify-center text-sm font-bold uppercase tracking-wide

        text-blue-600 dark:text-blue-300

        border border-blue-400/40 dark:border-blue-500/40

        bg-white/60 dark:bg-black/30 backdrop-blur

        px-3 py-2 rounded-full

        hover:bg-blue-500 hover:text-black

        dark:hover:bg-blue-500 dark:hover:text-white

        hover:border-blue-400

        transition-all duration-300
    ',

    'trash' => '
        inline-flex items-center gap-1 text-sm font-semibold
        text-gray-700 dark:text-gray-300
        bg-gray-200/40 dark:bg-gray-500/10
        hover:bg-gray-300/50 dark:hover:bg-gray-500/20
        border border-gray-300 dark:border-gray-500/30
        hover:border-gray-400
        px-4 py-2 rounded-lg transition
    ',

    
    'reset' =>'
        px-1 py-2 text-sm transition
        text-gray-500 hover:text-gray-800
        dark:text-gray-400 dark:hover:text-white
',

'like' => '
    inline-flex items-center justify-center
    h-8

    text-gray-500 dark:text-gray-400

    transition-all duration-200 ease-out
    transform

    hover:text-red-500
    hover:scale-125

    active:scale-90

    select-none
',

    default => '
        bg-blue-600 text-white hover:bg-blue-800
        dark:bg-blue-500 dark:hover:bg-blue-600
    ',
};
@endphp

@if($href)
    <a href="{{ $href }}"
        {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif