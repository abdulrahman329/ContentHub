<div>
<a
    {{ $attributes->merge([
        'class' => 'text-yellow-500 hover:text-yellow-700'
    ]) }}
>
    {{ $slot }}
</a>
</div>