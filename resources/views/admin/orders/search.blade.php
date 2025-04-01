@foreach ($orders as $order)
    <tr class="border-b border-gray-200 hover:bg-gray-50 transition" data-order-id="{{ $order->id }}">
        <td class="px-3 md:px-6 py-2 md:py-3 text-xs md:text-sm text-gray-800">#{{ $order->id }}</td>
        <td class="px-3 md:px-6 py-2 md:py-3 text-xs md:text-sm text-gray-800 max-w-[80px] md:max-w-none truncate">
            {{ $order->user->name ?? 'Guest' }}</td>
        <td class="px-3 md:px-6 py-2 md:py-3">
            <span
                class="px-1.5 md:px-2 py-0.5 md:py-1 rounded-lg text-white text-xs md:text-sm {{ $order->order_status == 'pending' ? 'bg-yellow-500' : ($order->order_status == 'shipped' ? 'bg-blue-500' : ($order->order_status == 'delivered' ? 'bg-green-500' : 'bg-red-500')) }}">{{ ucfirst($order->order_status) }}</span>
        </td>
        <td class="px-3 md:px-6 py-2 md:py-3 text-xs md:text-sm text-gray-600">
            ${{ number_format($order->total_price, 2) }}</td>
        <td class="hidden md:table-cell px-3 md:px-6 py-2 md:py-3 text-xs md:text-sm text-gray-600">
            {{ date('d M, Y', strtotime($order->order_date)) }}</td>
        <td class="px-3 md:px-12 py-2 md:py-3 flex space-x-2 md:space-x-4">
            <!-- View Button -->
            <button type="button" onclick="openViewModal({{ $order->id }})"
                class="text-green-500 hover:text-green-700 transition p-1">
                <i class="uil uil-eye"></i>
            </button>
        </td>
    </tr>
@endforeach
