@php
    $slides = [
        [
            'image' => Vite::asset('resources/images/slide-1.jpg'),
            'badge' => 'Opening Sale Discount 50%',
            'title' => 'SuperMarket For Fresh Grocery',
            'description' => 'Introduced a new model for online grocery shopping and convenient home delivery.',
            'link' => '/',
        ],
        [
            'image' => Vite::asset('resources/images/slider-2.jpg'),
            'badge' => 'Free Shipping - orders over $100',
            'title' => 'Free Shipping on orders over <span class="text-green-600">$100</span>',
            'description' => 'Free Shipping to First-Time Customers Only, After promotions and discounts are applied.',
            'link' => '/',
        ],
        [
            'image' => Vite::asset('resources/images/slider-3.jpg'),
            'badge' => 'Free Shipping - orders over $100',
            'title' => 'Free Shipping on orders over <span class="text-green-600">$100</span>',
            'description' => 'Free Shipping to First-Time Customers Only, After promotions and discounts are applied.',
            'link' => '/',
        ]
    ];
@endphp

<div id="default-carousel" class="relative w-full mt-3" data-carousel="slide">
    <!-- Carousel wrapper -->
    <div class="relative h-56 md:h-130 overflow-hidden rounded-lg">
        @foreach ($slides as $slide)
            <div class="hidden duration-700 ease-in-out w-full h-full flex items-center justify-start p-10 bg-cover bg-center bg-no-repeat" 
                 data-carousel-item 
                 style="background-image: url('{{ $slide['image'] }}');">
                
                <!-- Overlay Content -->
                <div class="p-6 rounded-lg max-w-md">
                    <span class="bg-yellow-400 text-black px-2 py-1 text-sm font-semibold rounded">
                        {{ $slide['badge'] }}
                    </span>
                    <h2 class="text-4xl font-extrabold text-gray-900 mt-2">
                        {!! $slide['title'] !!}
                    </h2>
                    <p class="text-gray-600 mt-2">
                        {{ $slide['description'] }}
                    </p>
                    <a href="{{ $slide['link'] }}" class="mt-4 inline-flex items-center gap-2 px-5 py-2 bg-gray-900 text-white rounded-md">
                        Shop Now →
                    </a>
                </div>

            </div>
        @endforeach
    </div>

    <!-- Slider indicators -->
    <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
        @foreach ($slides as $index => $slide)
            <button type="button" class="w-3 h-3 rounded-full bg-white opacity-50" 
                    aria-label="Slide {{ $index + 1 }}" 
                    data-carousel-slide-to="{{ $index }}"></button>
        @endforeach
    </div>
</div>
