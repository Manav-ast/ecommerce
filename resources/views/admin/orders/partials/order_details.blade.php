<div class="space-y-4">
    <!-- Order Status Toggle Section -->
    <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
        <h3 class="text-lg font-semibold mb-3">Order Status</h3>
        <div class="flex items-center justify-between">
            <div>
                <span
                    class="px-2 py-1 rounded-lg text-white 
                    {{ $order->order_status == 'pending'
                        ? 'bg-yellow-500'
                        : ($order->order_status == 'shipped'
                            ? 'bg-blue-500'
                            : ($order->order_status == 'delivered'
                                ? 'bg-green-500'
                                : 'bg-red-500')) }}">
                    {{ ucfirst($order->order_status) }}
                </span>
            </div>
            <div>
                <select id="orderStatusToggle"
                    class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    data-order-id="{{ $order->id }}">
                    <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered
                    </option>
                    <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled
                    </option>
                </select>
            </div>
        </div>
    </div>

    <!-- Order Items Section -->
    <div class="overflow-x-auto">
        <h3 class="text-lg font-semibold mb-3">Order Items</h3>
        <table class="min-w-full border border-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-gray-600">Product</th>
                    <th class="px-4 py-2 text-left text-gray-600">Price</th>
                    <th class="px-4 py-2 text-left text-gray-600">Quantity</th>
                    <th class="px-4 py-2 text-left text-gray-600">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $item)
                    <tr class="border-b border-gray-200">
                        <td class="px-4 py-2"><strong>{{ $item->product->name }}</strong></td>
                        <td class="px-4 py-2">${{ number_format($item->price, 2) }}</td>
                        <td class="px-4 py-2">{{ $item->quantity }}</td>
                        <td class="px-4 py-2">${{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50">
                <tr>
                    <td colspan="3" class="px-4 py-2 text-right font-semibold">Total:</td>
                    <td class="px-4 py-2 font-bold">${{ number_format($order->total_price, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Payment Information -->
    <div>
        <h3 class="text-lg font-semibold mb-3">Payment</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600">Method:</p>
                <p class="font-semibold">{{ ucfirst($order->payment->payment_method ?? 'N/A') }}</p>
            </div>
            <div>
                <p class="text-gray-600">Status:</p>
                <span
                    class="px-2 py-1 rounded-lg text-white inline-block
                    {{ $order->payment->payment_status == 'completed'
                        ? 'bg-green-500'
                        : ($order->payment->payment_status == 'pending'
                            ? 'bg-yellow-500'
                            : 'bg-red-500') }}">
                    {{ ucfirst($order->payment->payment_status ?? 'N/A') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Address Information -->
    <div>
        <h3 class="text-lg font-semibold mb-3">Address Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Billing Address -->
            <div class="border rounded-lg p-4 bg-gray-50">
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-md text-sm font-medium">Billing
                        Address</span>
                </div>
                @php
                    $billingAddress = $order->addresses->where('type', 'billing')->first();
                @endphp

                @if ($billingAddress)
                    <div class="space-y-1">
                        <p class="font-semibold">{{ $order->user->name }}</p>
                        <p>{{ $billingAddress->address_line1 }}</p>
                        @if ($billingAddress->address_line2)
                            <p>{{ $billingAddress->address_line2 }}</p>
                        @endif
                        <p>{{ $billingAddress->city }}, {{ $billingAddress->state }}
                            {{ $billingAddress->postal_code }}</p>
                        <p>{{ $billingAddress->country }}</p>
                        @if ($billingAddress->is_default)
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs">Default
                                Address</span>
                        @endif
                    </div>
                @else
                    <p class="text-gray-500">No billing address information available.</p>
                @endif
            </div>

            <!-- Shipping Address -->
            <div class="border rounded-lg p-4 bg-gray-50">
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-sm font-medium">Shipping
                        Address</span>
                </div>
                @php
                    $shippingAddress = $order->addresses->where('type', 'shipping')->first();
                @endphp

                @if ($shippingAddress)
                    <div class="space-y-1">
                        <p class="font-semibold">{{ $order->user->name }}</p>
                        <p>{{ $shippingAddress->address_line1 }}</p>
                        @if ($shippingAddress->address_line2)
                            <p>{{ $shippingAddress->address_line2 }}</p>
                        @endif
                        <p>{{ $shippingAddress->city }}, {{ $shippingAddress->state }}
                            {{ $shippingAddress->postal_code }}</p>
                        <p>{{ $shippingAddress->country }}</p>
                    </div>
                @else
                    <p class="text-gray-500">No shipping address information available.</p>
                @endif
            </div>
        </div>
    </div>
</div>
