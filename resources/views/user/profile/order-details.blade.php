<div class="space-y-6">
    <!-- Order Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="font-medium text-gray-700 mb-2">Order Information</h3>
            <p class="text-sm"><span class="text-gray-600">Order ID:</span> #{{ $order->id }}</p>
            <p class="text-sm"><span class="text-gray-600">Date:</span>
                {{ date('d M, Y', strtotime($order->order_date)) }}</p>
            <p class="text-sm"><span class="text-gray-600">Status:</span>
                <span
                    class="px-2 py-0.5 rounded-full text-xs font-medium 
                    {{ $order->order_status == 'pending'
                        ? 'bg-yellow-100 text-yellow-800'
                        : ($order->order_status == 'shipped'
                            ? 'bg-blue-100 text-blue-800'
                            : ($order->order_status == 'delivered'
                                ? 'bg-green-100 text-green-800'
                                : 'bg-red-100 text-red-800')) }}">
                    {{ ucfirst($order->order_status) }}
                </span>
            </p>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="font-medium text-gray-700 mb-2">Customer Information</h3>
            <p class="text-sm"><span class="text-gray-600">Name:</span> {{ $order->user->name }}</p>
            <p class="text-sm"><span class="text-gray-600">Email:</span> {{ $order->user->email }}</p>
            <p class="text-sm"><span class="text-gray-600">Phone:</span> {{ $order->user->phone_no ?? 'Not provided' }}
            </p>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="font-medium text-gray-700 mb-2">Payment Information</h3>
            @if ($order->payment)
                <p class="text-sm"><span class="text-gray-600">Method:</span>
                    {{ ucfirst($order->payment->payment_method) }}</p>
                <p class="text-sm"><span class="text-gray-600">Status:</span>
                    <span
                        class="px-2 py-0.5 rounded-full text-xs font-medium 
                        {{ $order->payment->payment_status == 'completed'
                            ? 'bg-green-100 text-green-800'
                            : ($order->payment->payment_status == 'pending'
                                ? 'bg-yellow-100 text-yellow-800'
                                : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($order->payment->payment_status) }}
                    </span>
                </p>
                <p class="text-sm"><span class="text-gray-600">Transaction ID:</span>
                    {{ $order->payment->transaction_id ?? 'N/A' }}</p>
            @else
                <p class="text-sm text-gray-600">No payment information available</p>
            @endif
        </div>
    </div>

    <!-- Order Items -->
    <div>
        <h3 class="font-medium text-gray-800 mb-3">Order Items</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Product</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Quantity</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($order->orderItems as $item)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    @if (isset($item->product) && $item->product)
                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                            alt="{{ $item->product->name }}"
                                            class="w-12 h-12 object-cover rounded-md mr-3">
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $item->product->name }}</p>
                                            <p class="text-xs text-gray-500">SKU: {{ $item->product->sku ?? 'N/A' }}
                                            </p>
                                        </div>
                                    @else
                                        <div>
                                            <p class="font-medium text-gray-800">
                                                {{ $item->product_name ?? 'Product not available' }}</p>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-600">${{ number_format($item->price, 2) }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $item->quantity }}</td>
                            <td class="px-4 py-3 font-medium text-gray-800">
                                ${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-right font-medium text-gray-700">Subtotal:</td>
                        <td class="px-4 py-3 font-medium text-gray-800">${{ number_format($order->total_price, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-right font-medium text-gray-700">Shipping:</td>
                        <td class="px-4 py-3 font-medium text-gray-800">$0.00</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-right font-medium text-gray-700">Total:</td>
                        <td class="px-4 py-3 font-medium text-gray-900 text-lg">
                            ${{ number_format($order->total_price, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Address Information -->
    <div>
        <h3 class="font-medium text-gray-800 mb-3">Address Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Billing Address -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-medium text-gray-700 mb-2">Billing Address</h4>
                @php
                    $billingAddress = $order->addresses->where('type', 'billing')->first();
                @endphp

                @if ($billingAddress)
                    <p class="text-gray-700">{{ $billingAddress->address_line1 }}</p>
                    @if ($billingAddress->address_line2)
                        <p class="text-gray-700">{{ $billingAddress->address_line2 }}</p>
                    @endif
                    <p class="text-gray-700">{{ $billingAddress->city }}, {{ $billingAddress->state }}
                        {{ $billingAddress->postal_code }}</p>
                    <p class="text-gray-700">{{ $billingAddress->country }}</p>
                    @if ($billingAddress->is_default)
                        <span class="inline-block mt-1 bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Default
                            Address</span>
                    @endif
                @else
                    <p class="text-gray-500">No billing address information available.</p>
                @endif
            </div>

            <!-- Shipping Address -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-medium text-gray-700 mb-2">Shipping Address</h4>
                @php
                    $shippingAddress = $order->addresses->where('type', 'shipping')->first();
                @endphp

                @if ($shippingAddress)
                    <p class="text-gray-700">{{ $shippingAddress->address_line1 }}</p>
                    @if ($shippingAddress->address_line2)
                        <p class="text-gray-700">{{ $shippingAddress->address_line2 }}</p>
                    @endif
                    <p class="text-gray-700">{{ $shippingAddress->city }}, {{ $shippingAddress->state }}
                        {{ $shippingAddress->postal_code }}</p>
                    <p class="text-gray-700">{{ $shippingAddress->country }}</p>
                @else
                    <p class="text-gray-500">No shipping address information available.</p>
                @endif
            </div>
        </div>
    </div>
</div>
