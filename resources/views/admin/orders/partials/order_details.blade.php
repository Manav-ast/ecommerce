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
        @php
            // First try to get shipping address
            $address = $order->user->addresses->where('type', 'shipping')->first();
            $addressType = 'Shipping';

            // If no shipping address found, try billing address
            if (!$address) {
                $address = $order->user->addresses->where('type', 'billing')->first();
                $addressType = 'Billing';
            }

            // If still no address, get any address
            if (!$address && $order->user->addresses->count() > 0) {
                $address = $order->user->addresses->first();
                $addressType = ucfirst($address->type);
            }
        @endphp

        @if ($address)
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded-md text-sm">{{ $addressType }} Address</span>
            </div>
            <p>{{ $address->address_line1 }}, {{ $address->city }}, {{ $address->state }},
                {{ $address->country }} - {{ $address->postal_code }}</p>
        @else
            <p class="text-gray-500">No address information available.</p>
        @endif
    </div>
</div>
