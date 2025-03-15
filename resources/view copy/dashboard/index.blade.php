<x-admin-layout>
    <div class="p-10 space-y-6">
        <!-- Welcome Section -->
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center justify-between 
                    bg-cover bg-center h-50" 
             style="background-image: url('{{ asset('images/grocery-banner.png') }}');">
            <div>
                <h1 class="text-2xl font-bold">Welcome back! FreshCart</h1>
                <p class="text-gray-600">FreshCart is a simple & clean design for developers and designers.</p>
                <button class="bg-green-600 text-white px-4 py-2 mt-4 rounded-md">Create Product</button>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md relative">
                <div class="absolute top-4 right-4 bg-red-100 text-red-600 p-2 rounded-full">
                    <i class="fa-solid fa-dollar-sign"></i>
                </div>
                <p class="text-gray-500">Earnings</p>
                <h2 class="text-2xl font-bold">$93,438.78</h2>
                <p class="text-sm text-gray-500">Monthly revenue</p>
            </div>

            <!-- Orders Card -->
            <div class="bg-white p-6 rounded-lg shadow-md relative">
                <div class="absolute top-4 right-4 bg-yellow-100 text-yellow-600 p-2 rounded-full">
                    <i class="fa-solid fa-shopping-cart"></i>
                </div>
                <p class="text-gray-500">Orders</p>
                <h2 class="text-2xl font-bold">42,339</h2>
                <p class="text-sm text-gray-500">35+ New Sales</p>
            </div>

            <!-- Customers Card -->
            <div class="bg-white p-6 rounded-lg shadow-md relative">
                <div class="absolute top-4 right-4 bg-blue-100 text-blue-600 p-2 rounded-full">
                    <i class="fa-solid fa-users"></i>
                </div>
                <p class="text-gray-500">Customers</p>
                <h2 class="text-2xl font-bold">39,354</h2>
                <p class="text-sm text-gray-500">30+ new in 2 days</p>
            </div>
        </div>

        <!-- Recent Orders Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Recent Orders</h2>
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-300 bg-white shadow-md rounded-lg">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 text-sm font-semibold">
                            <th class="p-3 text-left border-b border-gray-300">Order Number</th>
                            <th class="p-3 text-left border-b border-gray-300">Product Name</th>
                            <th class="p-3 text-left border-b border-gray-300">Order Date</th>
                            <th class="p-3 text-left border-b border-gray-300">Price</th>
                            <th class="p-3 text-left border-b border-gray-300">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm">
                        @foreach ($orders as $order)
                            <tr class="border-b border-gray-300 hover:bg-gray-50">
                                <td class="p-3">{{ $order->order_number }}</td>
                                <td class="p-3">{{ $order->product_name }}</td>
                                <td class="p-3">{{ $order->order_date }}</td>
                                <td class="p-3">${{ number_format($order->price, 2) }}</td>
                                <td class="p-3">
                                    @if($order->status == 'Shipped')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium flex items-center gap-1">
                                            <i class="fa-solid fa-truck"></i> Shipped
                                        </span>
                                    @elseif($order->status == 'Pending')
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-medium flex items-center gap-1">
                                            <i class="fa-solid fa-clock"></i> Pending
                                        </span>
                                    @elseif($order->status == 'Processing')
                                        <span class="bg-pink-100 text-pink-700 px-3 py-1 rounded-full text-xs font-medium flex items-center gap-1">
                                            <i class="fa-solid fa-spinner"></i> Processing
                                        </span>
                                    @elseif($order->status == 'Cancel')
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-medium flex items-center gap-1">
                                            <i class="fa-solid fa-times-circle"></i> Cancel
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        @if($orders->isEmpty())
                            <tr>
                                <td colspan="5" class="p-3 text-center text-gray-500 border-b border-gray-300">
                                    No recent orders available
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
