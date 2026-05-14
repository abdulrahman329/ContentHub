@props([
    'action',
    'method' => 'POST',
])

<form action="{{ $action }}" method="POST">

    @csrf

    @if(in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']))
        @method($method)
    @endif

    {{ $slot }}

</form>