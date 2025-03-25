@props(['title', 'value', 'icon' => 'uil uil-chart', 'color' => 'bg-blue-100 text-blue-600'])
<div class="bg-white p-6 rounded-lg shadow-md relative">
    <div class="absolute top-4 right-4 {{ $color }} p-2 rounded-full">
        <i class="{{ $icon }}"></i>
    </div>
    <h3 class="text-lg font-semibold">{{ $title }}</h3>
    <p class="text-2xl font-bold mt-2">{{ $value }}</p>
</div>
