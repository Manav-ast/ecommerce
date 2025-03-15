<x-admin-layout>    
    <section class="bg-white p-12 antialiased md:p-12">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0 mb-12">
            <h2 class="text-xl font-semibold text-gray-900 sm:text-2xl">Order List</h2>
            </div>

            <div class="mt-6 overflow-x-auto bg-white border border-gray-200 rounded-lg shadow-md">
                <table class="w-full text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 border-b">Image</th>
                            <th class="px-6 py-3 border-b">Order Number</th>
                            <th class="px-6 py-3 border-b">Customer</th>
                            <th class="px-6 py-3 border-b">Date & Time</th>
                            <th class="px-6 py-3 border-b">Payment</th>
                            <th class="px-6 py-3 border-b">Status</th>
                            <th class="px-6 py-3 border-b">Amount</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="border-b border-gray-200  hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <img src="{{ Vite::asset('resources/images/products/product-img-1.jpg') }}" alt="Product" class="h-10 w-10 rounded-lg">
                                </td>
                                <td class="px-6 py-4 font-medium">{{ $order->order_number }}</td>
                                <td class="px-6 py-4">{{ $order->customer }}</td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse(strtotime($order->order_date))->format('d M Y h:i A') }}
                                </td>
                                
                                <td class="px-6 py-4">{{ ucfirst($order->payment) }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-sm font-medium text-white rounded-lg" 
                                          style="background-color: {{ $order->status == 'Success' ? 'green' : ($order->status == 'Pending' ? 'yellow' : 'red') }};"> 
                                    
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-medium">${{ number_format(str_replace('$', '', $order->amount), 2) }}</td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-admin-layout>
