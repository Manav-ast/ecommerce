@extends('layouts.users.app')

@php
    $products = [
        ['id' => 1, 'name' => 'Guyer Chair', 'image' => 'assets/images/products/product1.jpg', 'price' => 45.00, 'old_price' => 55.90, 'reviews' => 150, 'category' => 'Chair'],
        ['id' => 2, 'name' => 'Modern Sofa', 'image' => 'assets/images/products/product2.jpg', 'price' => 120.00, 'old_price' => 150.00, 'reviews' => 98, 'category' => 'Sofa'],
        ['id' => 3, 'name' => 'Wooden Table', 'image' => 'assets/images/products/product3.jpg', 'price' => 75.00, 'old_price' => 90.00, 'reviews' => 200, 'category' => 'Table'],
        ['id' => 4, 'name' => 'Office Chair', 'image' => 'assets/images/products/product4.jpg', 'price' => 60.00, 'old_price' => 70.00, 'reviews' => 80, 'category' => 'Chair'],
        ['id' => 5, 'name' => 'Classic Lamp', 'image' => 'assets/images/products/product5.jpg', 'price' => 30.00, 'old_price' => 40.00, 'reviews' => 120, 'category' => 'Lamp'],
        ['id' => 6, 'name' => 'Bookshelf', 'image' => 'assets/images/products/product6.jpg', 'price' => 90.00, 'old_price' => 110.00, 'reviews' => 50, 'category' => 'Shelf'],
    ];

    $productId = request()->segment(2); // Get ID from URL
    $product = collect($products)->firstWhere('id', $productId);
    
    if (!$product) {
        abort(404, 'Product not found');
    }

    $thumbnailImages = array_column(array_slice($products, 0, 5), 'image');
    $relatedProducts = collect($products)->where('id', '!=', $productId)->shuffle()->take(4)->all();
@endphp

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-2 gap-6">
        <!-- Product Images -->
        <div>
            <img src="{{ asset($product['image'])}}" alt="{{ $product['name'] }}" class="w-full rounded-lg shadow-md">
            <div class="grid grid-cols-5 gap-4 mt-4">
                @foreach ($thumbnailImages as $thumbnail)
                    <img 
                        src="{{ asset($thumbnail) }}" 
                        alt="{{ $product['name'] }} thumbnail" 
                        class="w-full cursor-pointer border rounded hover:border-primary transition-colors {{ $thumbnail === $product['image'] ? 'border-primary' : 'border-gray-200' }}"
                    >
                @endforeach
            </div>
        </div>

        <!-- Product Details -->
        <div>
            <h2 class="text-3xl font-medium uppercase mb-2 text-gray-800">{{ $product['name'] }}</h2>
            <div class="flex items-center mb-4">
                <div class="flex gap-1 text-sm text-yellow-400">
                    @for ($i = 0; $i < 5; $i++)
                        <span><i class="fa-solid fa-star"></i></span>
                    @endfor
                </div>
                <div class="text-xs text-gray-500 ml-3">({{ $product['reviews'] }} Reviews)</div>
            </div>

            <div class="space-y-2">
                <p class="text-gray-800 font-semibold space-x-2">
                    <span>Availability:</span>
                    <span class="text-green-600">In Stock</span>
                </p>
                <p class="space-x-2">
                    <span class="text-gray-800 font-semibold">Brand:</span>
                    <span class="text-gray-600">Apex</span>
                </p>
                <p class="space-x-2">
                    <span class="text-gray-800 font-semibold">Category:</span>
                    <span class="text-gray-600">{{ $product['category'] }}</span>
                </p>
                <p class="space-x-2">
                    <span class="text-gray-800 font-semibold">SKU:</span>
                    <span class="text-gray-600">BE45VGRT-{{ $product['id'] }}</span>
                </p>
            </div>

            <div class="flex items-baseline mb-1 space-x-2 font-roboto mt-4">
                <p class="text-xl text-primary font-semibold">${{ number_format($product['price'], 2) }}</p>
                <p class="text-base text-gray-400 line-through">${{ number_format($product['old_price'], 2) }}</p>
            </div>

            <p class="mt-4 text-gray-600">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos eius eum reprehenderit dolore vel mollitia 
                optio consequatur hic asperiores inventore suscipit, velit consequuntur, voluptate doloremque iure 
                necessitatibus adipisci magnam porro.
            </p>

            <!-- Size Selection -->
            <div class="pt-4">
                <h3 class="text-sm text-gray-800 uppercase mb-1">Size</h3>
                <div class="flex items-center gap-2">
                    @foreach (['XS', 'S', 'M', 'L', 'XL'] as $size)
                        <div class="size-selector">
                            <input type="radio" name="size" id="size-{{ strtolower($size) }}" class="hidden" value="{{ $size }}">
                            <label for="size-{{ strtolower($size) }}"
                                class="text-xs border border-gray-200 rounded-sm h-6 w-6 flex items-center justify-center cursor-pointer shadow-sm text-gray-600 hover:border-primary transition-colors">
                                {{ $size }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Color Selection -->
            <div class="pt-4">
                <h3 class="text-xl text-gray-800 mb-3 uppercase font-medium">Color</h3>
                <div class="flex items-center gap-2">
                    @foreach (['#fc3d57' => 'red', '#000' => 'black', '#fff' => 'white'] as $color => $name)
                        <div class="color-selector">
                            <input type="radio" name="color" id="{{ $name }}" class="hidden" value="{{ $name }}">
                            <label for="{{ $name }}"
                                class="border border-gray-200 rounded-sm h-6 w-6 cursor-pointer shadow-sm block hover:border-primary transition-colors"
                                style="background-color: {{ $color }};"></label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Quantity Selection -->
            <div class="mt-4">
                <h3 class="text-sm text-gray-800 uppercase mb-1">Quantity</h3>
                <div class="flex border border-gray-300 text-gray-600 divide-x divide-gray-300 w-max">
                    <button class="h-8 w-8 text-xl flex items-center justify-center cursor-pointer select-none" onclick="updateQuantity(-1)">-</button>
                    <div class="h-8 w-8 text-base flex items-center justify-center" id="quantity">1</div>
                    <button class="h-8 w-8 text-xl flex items-center justify-center cursor-pointer select-none" onclick="updateQuantity(1)">+</button>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 flex gap-3 border-b border-gray-200 pb-5 pt-5">
                <button 
                    class="bg-primary border border-primary text-white px-8 py-2 font-medium rounded uppercase flex items-center gap-2 hover:bg-transparent hover:text-primary transition"
                    onclick="addToCart({{ $product['id'] }})">
                    <i class="fa-solid fa-bag-shopping"></i> Add to cart
                </button>
                <a href="#"
                    class="border border-gray-300 text-gray-600 px-8 py-2 font-medium rounded uppercase flex items-center gap-2 hover:text-primary transition">
                    <i class="fa-solid fa-heart"></i> Wishlist
                </a>
            </div>

            <!-- Social Sharing -->
            <div class="flex gap-3 mt-4">
                @foreach (['facebook-f' => '#', 'twitter' => '#', 'instagram' => '#'] as $icon => $url)
                    <a href="{{ $url }}"
                        class="text-gray-400 hover:text-gray-500 h-8 w-8 rounded-full border border-gray-300 flex items-center justify-center transition-colors">
                        <i class="fa-brands fa-{{ $icon }}"></i>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <div class="pt-16">
        <h2 class="text-2xl font-medium text-gray-800 uppercase mb-6">Related Products</h2>
        <div class="grid grid-cols-4 gap-6">
            @foreach ($relatedProducts as $related)
                <div class="bg-white shadow rounded overflow-hidden group">
                    <div class="relative">
                        <img src="" alt="{{ $related['name'] }}" class="w-full">
                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition">
                            <a href="{{ url('/products/' . $related['id']) }}"
                                class="text-white text-lg w-9 h-8 rounded-full bg-primary flex items-center justify-center hover:bg-gray-800 transition"
                                title="View product">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </a>
                            <a href="#"
                                class="text-white text-lg w-9 h-8 rounded-full bg-primary flex items-center justify-center hover:bg-gray-800 transition"
                                title="Add to wishlist">
                                <i class="fa-solid fa-heart"></i>
                            </a>
                        </div>
                    </div>
                    <div class="pt-4 pb-3 px-4">
                        <a href="{{ url('/products/' . $related['id']) }}">
                            <h4 class="uppercase font-medium text-xl mb-2 text-gray-800 hover:text-primary transition">
                                {{ $related['name'] }}
                            </h4>
                        </a>
                        <div class="flex items-baseline mb-1 space-x-2">
                            <p class="text-xl text-primary font-semibold">${{ number_format($related['price'], 2) }}</p>
                            <p class="text-sm text-gray-400 line-through">${{ number_format($related['old_price'], 2) }}</p>
                        </div>
                        <div class="flex items-center">
                            <div class="flex gap-1 text-sm text-yellow-400">
                                @for ($i = 0; $i < 5; $i++)
                                    <span><i class="fa-solid fa-star"></i></span>
                                @endfor
                            </div>
                            <div class="text-xs text-gray-500 ml-3">({{ $related['reviews'] }})</div>
                        </div>
                    </div>
                    <button 
                        class="block w-full py-1 text-center text-white bg-primary border border-primary rounded-b hover:bg-transparent hover:text-primary transition"
                        onclick="addToCart({{ $related['id'] }})">
                        Add to cart
                    </button>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function updateQuantity(change) {
        const quantityElement = document.getElementById('quantity');
        let quantity = parseInt(quantityElement.textContent);
        quantity = Math.max(1, quantity + change);
        quantityElement.textContent = quantity;
    }

    function addToCart(productId) {
        let quantity = document.getElementById("quantity") ? document.getElementById("quantity").textContent : 1;
        
        fetch("{{ url('/cart/add') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the cart count dynamically
                let cartCountElement = document.getElementById("cart-count");
                cartCountElement.innerText = data.cart_count;

                // Ensure cart count is visible
                if (data.cart_count > 0) {
                    cartCountElement.classList.remove("hidden");
                }
            }
        })
        .catch(error => console.error("Error:", error));
    }
</script>
@endsection