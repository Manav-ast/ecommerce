@props(['product'])
<div class="bg-white shadow-lg rounded-xl overflow-hidden flex flex-col h-full transition-all duration-300 hover:shadow-2xl">
    <!-- Image Section -->
    <div class="relative">
        <a href="{{ url('products/' . $product['id']) }}">
            <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="w-full h-56 object-cover transition-transform duration-300 hover:scale-105">
        </a>
    </div>

    <!-- Content Section -->
    <div class="p-5 flex-grow relative">
        <!-- Wishlist Icon -->
        <button class="wishlist-btn absolute top-2 right-2 text-gray-500 text-lg w-9 h-9 rounded-full flex items-center justify-center hover:bg-gray-100 hover:text-red-500 transition-all duration-200">
            <i class="fa-solid fa-heart"></i>
        </button>
        <h4 class="uppercase font-semibold text-lg mb-3 text-gray-800 tracking-wide line-clamp-1 hover:text-primary transition-colors duration-200">
            {{ $product['name'] }}
        </h4>
        <div class="flex items-baseline mb-4 space-x-3">
            <p class="text-2xl text-primary font-bold">${{ $product['price'] }}</p>
            @if (isset($product['old_price']))
                <p class="text-sm text-gray-400 line-through">${{ $product['old_price'] }}</p>
            @endif
        </div>
        <div class="flex items-center mb-4">
            <div class="flex gap-1 text-sm text-yellow-400">
                @for ($i = 0; $i < 5; $i++)
                    <span><i class="fa-solid fa-star"></i></span>
                @endfor
            </div>
            <div class="text-xs text-gray-500 ml-2 font-light">({{ $product['reviews'] }})</div>
        </div>
    </div>

    <!-- Footer Section -->
    <div class="px-5 pb-5">
        <button class="bg-primary border border-primary text-white px-8 py-3 font-medium rounded-lg uppercase flex items-center justify-center gap-2 hover:bg-transparent hover:text-primary transition-all duration-200 w-full" onclick="addToCart({{ $product['id'] }})">
            <i class="fa-solid fa-bag-shopping"></i> Add to Cart
        </button>
    </div>
</div>