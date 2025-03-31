@props(['title', 'value', 'icon' => 'uil uil-chart', 'color' => 'bg-blue-100 text-blue-600'])
<div class="bg-white p-3 md:p-6 rounded-lg shadow-md relative">
    <div class="absolute top-3 md:top-4 right-3 md:right-4 {{ $color }} p-1.5 md:p-2 rounded-full">
        <i class="{{ $icon }} text-sm md:text-base"></i>
    </div>
    <h3 class="text-base md:text-lg font-semibold truncate">{{ $title }}</h3>
    <p class="text-xl md:text-2xl font-bold mt-1 md:mt-2">{{ $value }}</p>
</div>
