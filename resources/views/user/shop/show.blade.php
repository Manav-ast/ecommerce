@extends('layouts.users.app')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Product Image -->
            <div class="relative">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                    class="w-full h-[450px] object-cover rounded-lg shadow-lg transition-transform hover:scale-105">
            </div>

            <!-- Product Details -->
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 mb-4">{{ $product->name }}</h1>

                <div class="flex items-center gap-2">
                    <p class="text-3xl text-blue-600 font-bold">${{ number_format($product->price, 2) }}</p>
                    @if ($product->old_price)
                        <p class="text-lg text-gray-400 line-through">${{ number_format($product->old_price, 2) }}</p>
                    @endif
                </div>

                <p class="mt-4 text-gray-600 leading-relaxed">{{ $product->description }}</p>

                <!-- Categories -->
                <div class="mt-4">
                    <h3 class="text-lg font-semibold text-gray-800">Categories:</h3>
                    <div class="flex gap-2 mt-1">
                        @foreach ($product->categories as $category)
                            <span class="bg-gray-200 text-gray-700 px-3 py-1 text-sm rounded-full">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <!-- Stock & SKU -->
                <div class="mt-4 space-y-2">
                    <p class="text-gray-700 font-medium">SKU: <span class="text-gray-500">#{{ $product->id }}</span></p>
                    <p class="text-gray-700 font-medium">
                        Availability:
                        <span class="{{ $product->stock_quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                        </span>
                    </p>
                </div>

                <!-- Quantity Selector -->
                <div class="mt-6 flex items-center gap-4">
                    <label for="quantity" class="text-lg font-medium text-gray-700">Quantity:</label>
                    <div class="flex items-center border border-gray-300 rounded-full">
                        <button type="button" id="decrease-quantity"
                            class="px-3 py-2 bg-gray-200 hover:bg-gray-300 rounded-l-full">-</button>
                        <input type="number" id="quantity" value="1" min="1"
                            max="{{ $product->stock_quantity }}"
                            class="w-16 text-center text-lg font-medium border-none focus:ring-0">
                        <button type="button" id="increase-quantity"
                            class="px-3 py-2 bg-gray-200 hover:bg-gray-300 rounded-r-full">+</button>
                    </div>
                </div>

                <!-- Add to Cart -->
                <div class="mt-6 flex gap-4">
                    <button id="add-to-cart"
                        class="bg-blue-600 text-white px-8 py-3 rounded-full text-lg font-medium shadow hover:bg-blue-700 transition">
                        <i class="fa-solid fa-bag-shopping"></i> Add to Cart
                    </button>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <div class="mt-16">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Related Products</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach ($relatedProducts as $related)
                    <x-users.product-card :product="$related" />
                @endforeach
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- JavaScript with jQuery -->
    <script>
        $(document).ready(function() {
            // Increase quantity
            $("#increase-quantity").click(function() {
                let quantityInput = $("#quantity");
                let quantity = parseInt(quantityInput.val());
                let maxStock = {{ $product->stock_quantity }};
                if (quantity < maxStock) {
                    quantityInput.val(quantity + 1);
                }
            });

            // Decrease quantity
            $("#decrease-quantity").click(function() {
                let quantityInput = $("#quantity");
                let quantity = parseInt(quantityInput.val());
                if (quantity > 1) {
                    quantityInput.val(quantity - 1);
                }
            });

            // Add to Cart
            $("#add-to-cart").click(function() {
                let productId = {{ $product->id }};
                let quantity = $("#quantity").val();

                $.post("{{ url('/cart/add') }}", {
                    _token: "{{ csrf_token() }}",
                    product_id: productId,
                    quantity: quantity
                }, function(data) {
                    if (data.success) {
                        // Update cart count dynamically
                        $("#cart-count").text(data.cart_count);

                        // Ensure cart count is visible
                        if (data.cart_count > 0) {
                            $("#cart-count").removeClass("hidden");
                        }

                        // Show success message
                        showSuccessToast("Product added to cart successfully!");
                    }
                });
            });
        });

        function showSuccessToast(message) {
            $("body").append(`
                <div class="fixed bottom-4 right-4 bg-green-600 text-white px-4 py-3 rounded-lg shadow-md">
                    ${message}
                </div>
            `);
            setTimeout(function() {
                $(".fixed.bottom-4.right-4").fadeOut(500, function() {
                    $(this).remove();
                });
            }, 3000);
        }
    </script>
@endsection
