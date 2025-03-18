<div class="space-y-4">
    <h3 class="text-lg font-semibold">Order Items</h3>
    <ul class="list-disc list-inside">
        @foreach ($order->orderItems as $item)
            <li>
                <strong>{{ $item->product->name }}</strong> -
                ${{ number_format($item->price, 2) }} (x{{ $item->quantity }})
            </li>
        @endforeach
    </ul>

    <h3 class="text-lg font-semibold">Payment</h3>
    <p>Method: <strong>{{ ucfirst($order->payment->payment_method ?? 'N/A') }}</strong></p>
    <p>Status: <span
            class="px-2 py-1 rounded-lg text-white 
        {{ $order->payment->payment_status == 'completed'
            ? 'bg-green-500'
            : ($order->payment->payment_status == 'pending'
                ? 'bg-yellow-500'
                : 'bg-red-500') }}">
            {{ ucfirst($order->payment->payment_status ?? 'N/A') }}
        </span></p>

    <h3 class="text-lg font-semibold">Shipping Address</h3>
    @php
        $shippingAddress = $order->user->addresses->where('type', 'shipping')->first();
    @endphp
    @if ($shippingAddress)
        <p>{{ $shippingAddress->address_line1 }}, {{ $shippingAddress->city }}, {{ $shippingAddress->state }},
            {{ $shippingAddress->country }} - {{ $shippingAddress->postal_code }}</p>
    @else
        <p class="text-gray-500">No shipping address available.</p>
    @endif
</div>
