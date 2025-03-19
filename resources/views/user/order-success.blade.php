@extends('layouts.users.app')

@section('content')
<div class="container mx-auto px-4 py-16 text-center">
    <h1 class="text-3xl font-bold text-green-600 mb-4">Order Placed Successfully!</h1>
    <p class="text-gray-700 text-lg">Thank you for your purchase. Your order ID is <strong>#{{ $order->id }}</strong>.</p>
    
    <h2 class="text-2xl font-semibold text-gray-800 mt-8">Order Summary</h2>
    <div class="mt-6 max-w-lg mx-auto bg-white shadow-md p-6 rounded-lg">
        @foreach ($order->orderItems as $item)
            <div class="flex justify-between border-b py-2">
                <span>{{ $item->product->name }}</span>
                <span>x{{ $item->quantity }}</span>
                <span class="text-gray-800 font-medium">${{ number_format($item->price * $item->quantity, 2) }}</span>
            </div>
        @endforeach
        <div class="flex justify-between text-lg font-semibold mt-4">
            <span>Total:</span>
            <span class="text-green-600">${{ number_format($order->total_price, 2) }}</span>
        </div>
    </div>

    <a href="{{ route('shop.index') }}" class="mt-6 inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">Continue Shopping</a>
</div>
@endsection
