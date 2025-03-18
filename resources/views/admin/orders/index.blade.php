@extends('admin.dashboard')

@section('content')
    <div class="p-10">
        <!-- Page Title -->
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Orders</h2>

        <!-- Search Bar -->
        <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-md">
            <input type="text" id="searchInput" placeholder="Search Orders"
                class="border p-2 rounded-md w-1/3 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Orders Table -->
        <div class="mt-6 bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-gray-600">Order ID</th>
                        <th class="px-6 py-3 text-left text-gray-600">Customer</th>
                        <th class="px-6 py-3 text-left text-gray-600">Status</th>
                        <th class="px-6 py-3 text-left text-gray-600">Total Price</th>
                        <th class="px-6 py-3 text-left text-gray-600">Order Date</th>
                        <th class="px-6 py-3 text-left text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody id="orderTableBody">
                    @foreach ($orders as $order)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                            <td class="px-6 py-3 text-gray-800">{{ $order->id }}</td>
                            <td class="px-6 py-3 text-gray-800">{{ $order->user->name ?? 'Guest' }}</td>
                            <td class="px-6 py-3">
                                <span
                                    class="px-2 py-1 rounded-lg text-white 
                                    {{ $order->order_status == 'pending'
                                        ? 'bg-yellow-500'
                                        : ($order->order_status == 'shipped'
                                            ? 'bg-blue-500'
                                            : ($order->order_status == 'delivered'
                                                ? 'bg-green-500'
                                                : 'bg-red-500')) }} ">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-gray-600">${{ number_format($order->total_price, 2) }}</td>
                            <td class="px-6 py-3 text-gray-600">{{ date('d M, Y', strtotime($order->order_date)) }}</td>
                            <td class="px-6 py-3 flex space-x-4">
                                <!-- View Button -->
                                <button type="button" onclick="openViewModal({{ $order->id }})"
                                    class="text-green-500 hover:text-green-700 transition">
                                    <i class="uil uil-eye"></i>
                                </button>


                                <!-- Edit Button -->
                                <a href="{{ route('admin.orders.edit', $order->id) }}"
                                    class="text-blue-500 hover:text-blue-700 transition">
                                    <i class="uil uil-edit"></i>
                                </a>

                                <!-- Delete Button -->
                                <button type="button"
                                    onclick="openDeleteModal({{ $order->id }}, 'Order #{{ $order->id }}')"
                                    class="text-red-500 hover:text-red-700 transition">
                                    <i class="uil uil-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>

    <!-- View Order Details Modal -->
    <!-- View Order Details Modal -->
    <div id="viewOrderModal" class="fixed inset-0 flex items-center justify-center hidden bg-gray-900 bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-3/4 max-w-4xl">
            <h2 class="text-xl font-semibold text-gray-800">Order Details</h2>
            <div id="orderDetailsContent" class="mt-4"></div>

            <button type="button" onclick="closeViewModal()"
                class="mt-4 bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                Close
            </button>
        </div>
    </div>


    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center hidden bg-gray-900 bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-semibold text-gray-800">Confirm Deletion</h2>
            <p class="text-gray-600 mt-2" id="deleteMessage"></p>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="mt-4 flex justify-end space-x-2">
                    <button type="button" onclick="closeDeleteModal()"
                        class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                        Cancel
                    </button>
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for Delete & View Order Details -->
    <script>
        function openViewModal(orderId) {
            fetch("{{ url('/admin/orders/details') }}/" + orderId, {
                    method: "GET",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.html) {
                        document.getElementById("orderDetailsContent").innerHTML = data.html;
                        document.getElementById("viewOrderModal").classList.remove("hidden");
                    } else {
                        document.getElementById("orderDetailsContent").innerHTML =
                            "<p class='text-red-500'>Order details not found.</p>";
                        document.getElementById("viewOrderModal").classList.remove("hidden");
                    }
                })
                .catch(error => {
                    console.error("Fetch error:", error);
                    document.getElementById("orderDetailsContent").innerHTML =
                        "<p class='text-red-500'>Something went wrong.</p>";
                    document.getElementById("viewOrderModal").classList.remove("hidden");
                });
        }

        function closeViewModal() {
            document.getElementById("viewOrderModal").classList.add("hidden");
        }
    </script>
@endsection
