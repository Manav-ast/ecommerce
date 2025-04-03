@extends('layouts.users.app')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <div class="w-full max-w-4xl mx-auto py-10">
            <div class="flex flex-col lg:flex-row flex-wrap items-start gap-6">
                <!-- Left Section: Cart Items -->
                <div class="lg:w-2/3 w-full">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center lg:text-left">Your Cart</h2>
                    <div id="cart-items" class="space-y-4">
                        @forelse ($cart as $key => $cartItem)
                            <x-users.cart-item :image="'storage/' . $cartItem['image']" :name="$cartItem['name']" :availability="$cartItem['quantity'] > 0 ? 'In Stock' : 'Out of Stock'" :quantity="$cartItem['quantity']"
                                :price="$cartItem['price'] * $cartItem['quantity']" :productId="$key" />
                        @empty
                            <p class="text-gray-500 text-center">Your cart is empty.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Right Section: Cart Summary -->
                <div class="lg:w-1/3 w-full">
                    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm sticky top-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Cart Summary</h3>
                        <div class="flex justify-between items-center mb-6">
                            <p class="text-sm font-medium text-gray-700">Total:</p>
                            <p id="cart-total" class="text-xl font-bold text-blue-500">${{ number_format($cartTotal, 2) }}</p>
                        </div>
                        <div class="space-y-3">
                            <a href="{{ route('checkout.index') }}"
                                class="block w-full px-4 py-2 text-white bg-blue-500 border border-blue-500 rounded-lg hover:bg-blue-600 transition-all duration-200 text-xs font-medium text-center">
                                Checkout
                            </a>
                            <a href="{{ url('/shop') }}"
                                class="block w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100 transition-all duration-200 text-xs font-medium text-center">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('user.cart.partials.delete-confirmation-modal')
@endsection
@push('scripts')
    


    <!-- JavaScript for Updating Cart -->
    <script>
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

        // Store the product ID to be deleted
        let productIdToDelete = null;

        // Show delete confirmation modal
        function removeFromCart(productId) {
            // Store the product ID for later use
            productIdToDelete = productId;

            // Show the modal
            document.getElementById("deleteCartItemModal").classList.remove("hidden");

            // Set up the confirm button to call the actual delete function
            document.getElementById("confirmDeleteBtn").onclick = function() {
                performCartItemDeletion(productIdToDelete);
            };
        }

        // Close the delete confirmation modal
        function closeDeleteModal() {
            document.getElementById("deleteCartItemModal").classList.add("hidden");
        }

        // Actual function to remove item from cart
        function performCartItemDeletion(productId) {
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
                        // Close the modal
                        closeDeleteModal();

                        // Update the cart display
                        document.getElementById("cart-items").innerHTML = data.cartHtml;
                        document.getElementById("cart-total").innerText = `$${data.cartTotal}`;

                        let cartCountElement = document.getElementById("cart-count");
                        cartCountElement.innerText = data.cartCount;
                        if (data.cartCount == 0) {
                            cartCountElement.classList.add("hidden");
                        } else {
                            cartCountElement.classList.remove("hidden");
                        }

                        // Show success message
                        showSuccessToast('Item removed from cart successfully!');
                    }
                });
        }
    </script>
@endpush