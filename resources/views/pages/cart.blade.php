@extends('layouts.users.app')

@section('content')
    <div class="w-full max-w-4xl mx-auto py-10 px-4">
        <!-- Responsive Wrapper: Column Layout on Mobile, Row Layout on Large Screens -->
        <div class="flex flex-col lg:flex-row lg:items-start lg:gap-6">

            <!-- Left Section: Cart Items -->
            <div class="w-full lg:w-2/3">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center lg:text-left">Your Cart</h2>

                <div class="space-y-4">
                    @forelse ($cartItems as $cart)
                        <x-users.cart-item :image="$cart['image']" :name="$cart['name']" :availability="$cart['availability']" :quantity="$cart['quantity']"
                            :price="$cart['price']" :productId="$cart['id']" />
                    @empty
                        <!-- Empty Cart Message -->
                        <div class="flex flex-col items-center justify-center py-10">
                            <!-- Cart Icon -->
                            <i class="fa-solid fa-cart-shopping text-6xl text-gray-400"></i>

                            <!-- Empty Cart Message -->
                            <p class="text-lg font-semibold text-gray-700 mt-4">Your cart is empty</p>

                            <a href="/shop"
                                class="mt-4 px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 transition-all duration-200">
                                Continue Shopping
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Right Section: Cart Summary (Only Show If Cart Is Not Empty) -->
            @if (!empty($cartItems) && count($cartItems) > 0)
                <div class="w-full lg:w-1/3 mt-6 lg:mt-0">
                    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm w-full">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center lg:text-left">Cart Summary</h3>

                        <div class="flex justify-between items-center mb-6">
                            <p class="text-sm font-medium text-gray-700">Total:</p>
                            <p class="text-xl font-bold text-red-500">${{ array_sum(array_column($cartItems, 'price')) }}
                            </p>
                        </div>

                        <div class="space-y-3">
                            <a href="/checkout"
                                class="block w-full px-4 py-2 text-white bg-red-500 border border-red-500 rounded-lg hover:bg-red-600 transition-all duration-200 text-xs font-medium text-center">
                                Checkout
                            </a>
                            <a href="/shop"
                                class="block w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100 transition-all duration-200 text-xs font-medium text-center">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
