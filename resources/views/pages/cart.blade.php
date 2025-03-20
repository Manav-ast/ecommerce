@extends('layouts.users.app')

@section('content')

<div class="w-full max-w-4xl mx-auto py-10">
    <div class="flex flex-col lg:flex-row items-start gap-6">
        <!-- Left Section: Cart Items -->
        <div class="lg:w-2/3 flex-1">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center lg:text-left">Your Cart</h2>
            <div class="space-y-4">
                @foreach ($cartItems as $cart)
                    <x-users.cart-item 
                        :image="$cart['image']"
                        :name="$cart['name']"
                        :availability="$cart['availability']"
                        :quantity="$cart['quantity']"
                        :price="$cart['price']"
                    />
                @endforeach
            </div>
        </div>

        <!-- Right Section: Cart Summary -->
        <div class="lg:w-1/3 flex-shrink-0">
            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm sticky top-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Cart Summary</h3>
                <div class="flex justify-between items-center mb-6">
                    <p class="text-sm font-medium text-gray-700">Total:</p>
                    <p class="text-xl font-bold text-red-500">${{ array_sum(array_column($cartItems, 'price')) }}</p>
                </div>
                <div class="space-y-3">
                    <a href="/checkout" class="block w-full px-4 py-2 text-white bg-red-500 border border-red-500 rounded-lg hover:bg-red-600 transition-all duration-200 text-xs font-medium text-center">
                        Checkout
                    </a>
                    <a href="/shop" class="block w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100 transition-all duration-200 text-xs font-medium text-center">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
