@props(['orders'])
<div class="bg-white rounded-lg shadow-md overflow-auto">
    <div class="p-3 md:p-4 border-b border-gray-200">
        <h3 class="text-base md:text-lg font-semibold">Recent Orders</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <!-- Responsive table with horizontal scrolling on mobile -->
            <thead class="bg-gray-50">
                <tr>
                    <th
                        class="px-2 md:px-6 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Order ID
                    </th>
                    <th
                        class="px-2 md:px-6 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Customer
                    </th>
                    <th
                        class="px-2 md:px-6 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Amount
                    </th>
                    <th
                        class="hidden md:table-cell px-2 md:px-6 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Date</th>
                    <th
                        class="px-2 md:px-6 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($orders as $order)
                    <tr>
                        <td
                            class="px-2 md:px-6 py-2 md:py-4 whitespace-nowrap text-xs md:text-sm font-medium text-gray-900">
                            #{{ $order->id }}
                        </td>
                        <td
                            class="px-2 md:px-6 py-2 md:py-4 whitespace-nowrap text-xs md:text-sm text-gray-500 max-w-[80px] md:max-w-none truncate">
                            {{ $order->user->name }}</td>
                        <td class="px-2 md:px-6 py-2 md:py-4 whitespace-nowrap text-xs md:text-sm text-gray-500">
                            ${{ number_format($order->total_price, 2) }}</td>
                        <td
                            class="hidden md:table-cell px-2 md:px-6 py-2 md:py-4 whitespace-nowrap text-xs md:text-sm text-gray-500">
                            {{ $order->created_at->format('M d, Y') }}</td>
                        <td class="px-2 md:px-6 py-2 md:py-4 whitespace-nowrap">
                            <span
                                class="px-1.5 md:px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Completed
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5"
                            class="px-4 md:px-6 py-3 md:py-4 text-center text-xs md:text-sm text-gray-500">No recent
                            orders found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
