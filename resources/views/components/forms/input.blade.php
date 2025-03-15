@props(['label', 'name','placeholder'])

@php
    $defaults = [
        'type' => 'text',
        'id' => $name,
        'name' => $name,
        'placeholder' => $placeholder,
        'class' => 'w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900 focus:ring-2 
                    focus:ring-green-500 focus:border-green-500 placeholder-gray-400 shadow-sm 
                    transition duration-200 ease-in-out',
        'value' => old($name)

    ];
@endphp

<x-forms.field :$label :$name :$placeholder>
    <input {{ $attributes($defaults) }}>
</x-forms.field>

