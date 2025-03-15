@php
    $class = 'flex text-lg hover:text-green-600 font-bold';

    if ($active) {
        $class .= ' text-green-600';
    } else {
        $class .= ' text-gray-900';
    }
@endphp

@props(['active' => false])

<a {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</a>
