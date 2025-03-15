@props(['active' => false])

@php
    $class = 'flex  text-m items-center px-3 py-2 rounded-md';

    if ($active) {
        $class .= ' bg-green-100 text-green-700 hover:bg-green-200';
    } else {
        $class .= ' text-gray-600 hover:bg-gray-100';
    }
@endphp

<a {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</a>    
