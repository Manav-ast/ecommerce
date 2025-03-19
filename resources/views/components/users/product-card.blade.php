@props(['product'])

<div
    class="bg-white shadow-lg rounded-xl overflow-hidden flex flex-col h-full transition-all duration-300 hover:shadow-2xl">
    <!-- Clickable Wrapper -->
    <a href="{{ route('shop.show', $product->slug) }}" class="flex flex-col flex-grow">
        <!-- Image Section -->
        <div class="relative group">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                class="w-full h-56 object-cover transition-transform duration-300 group-hover:scale-105">
            <!-- Overlay on Hover -->
            <div class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition-all duration-300">
            </div>
        </div>

        <!-- Content Section -->
        <div class="p-6 flex-grow relative">
            <h4
                class="uppercase font-semibold text-lg mb-1 text-gray-800 tracking-wide hover:text-blue-500 transition-colors duration-200">
                {{ $product->name }}
            </h4>

            <!-- Category Display -->
            @if ($product->categories->count())
                <p class="text-sm text-gray-500 mb-3">
                    {{-- Category: --}}
                    @foreach ($product->categories as $category)
                        <span class="bg-gray-200 text-gray-700 px-3 py-1 text-xs mr-1 rounded-full">
                            {{ $category->name }}
                        </span>
                    @endforeach
                </p>
            @endif

            <!-- Price -->
            <div class="flex items-center justify-between mb-4">
                <p class="text-2xl text-blue-500 font-bold">${{ number_format($product->price, 2) }}</p>
                @if ($product->old_price)
                    <p class="text-sm text-gray-400 line-through">${{ number_format($product->old_price, 2) }}</p>
                @endif
            </div>
        </div>
    </a>

    <!-- Footer Section (Add to Cart button remains outside the clickable area) -->
    <div class="px-6 pb-6">
        <button
            class="bg-blue-600 text-white px-8 py-3 rounded-full text-lg font-medium shadow hover:bg-blue-700 transition"
            onclick="addToCart({{ $product->id }})">
            <i class="fa-solid fa-bag-shopping"></i> Add to Cart
        </button>

    </div>
</div>


<script>
    function addToCart(productId) {
        let quantity = document.getElementById("quantity") ? document.getElementById("quantity").value : 1;

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
                    document.getElementById("cart-count").innerText = data.cart_count;
                }
            })
            .catch(error => console.error("Error:", error));
    }

    function updateCart(productId, action) {
        fetch("{{ url('/cart/update') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    product_id: productId,
                    action: action
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById("cart-items").innerHTML = data.cartHtml;
                    document.getElementById("cart-total").innerText = `$${data.cartTotal}`;

                    let cartCountElement = document.getElementById("cart-count");
                    cartCountElement.innerText = data.cartCount;
                    if (data.cartCount == 0) {
                        cartCountElement.classList.add("hidden");
                    } else {
                        cartCountElement.classList.remove("hidden");
                    }
                }
            });
    }

    function removeFromCart(productId) {
        fetch("{{ url('/cart/remove') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById("cart-items").innerHTML = data.cartHtml;
                    document.getElementById("cart-total").innerText = `$${data.cartTotal}`;

                    let cartCountElement = document.getElementById("cart-count");
                    cartCountElement.innerText = data.cartCount;
                    if (data.cartCount == 0) {
                        cartCountElement.classList.add("hidden");
                    } else {
                        cartCountElement.classList.remove("hidden");
                    }
                }
            });
    }
</script>
