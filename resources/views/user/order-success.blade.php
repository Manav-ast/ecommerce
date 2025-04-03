@extends('layouts.users.app')

@section('content')
    <div class="container py-16 px-4 sm:px-6">
        <div class="max-w-lg mx-auto px-6 py-8 bg-white rounded-md shadow-md">
            <div class="text-center">
                <div class="flex justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <h2 class="text-2xl sm:text-3xl font-semibold text-gray-800 mb-2">Order Confirmed!</h2>
                <p class="text-gray-600 mb-6 text-sm sm:text-base">Thank you for your purchase. Your order has been received.</p>

                <div class="bg-gray-50 p-4 rounded-md mb-6 text-sm sm:text-base">
                    <h3 class="font-medium text-gray-800 mb-2">Order #{{ $order->id }}</h3>
                    <p class="text-gray-600">Placed on {{ $order->created_at->format('F j, Y') }}</p>
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <h3 class="font-medium text-gray-800 mb-4">Order Summary</h3>

                    <div class="space-y-3">
                        @foreach ($order->orderItems as $item)
                            <div class="flex justify-between text-xs sm:text-sm">
                                <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
                                <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
                            </div>
                        @endforeach

                        <div class="border-t border-gray-200 pt-3 mt-3">
                            <div class="flex justify-between text-xs sm:text-sm">
                                <span>Subtotal</span>
                                <span>${{ number_format($order->total_price, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-xs sm:text-sm">
                                <span>Shipping</span>
                                <span class="text-green-600">Free</span>
                            </div>
                            <div class="flex justify-between font-medium mt-2 text-sm sm:text-base">
                                <span>Total</span>
                                <span>${{ number_format($order->total_price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 space-y-3">
                    <a href="{{ route('home') }}"
                        class="block w-full py-2 px-4 text-center text-white bg-blue-500 border border-blue-500 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-sm sm:text-base">
                        Continue Shopping
                    </a>
                    <a href="{{ route('profile.orders') }}"
                        class="block w-full py-2 px-4 text-center text-blue-500 bg-white border border-blue-500 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-sm sm:text-base">
                        View My Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
