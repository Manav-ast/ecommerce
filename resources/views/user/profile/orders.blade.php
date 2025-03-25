@extends('layouts.users.app')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="flex flex-wrap -mx-4">
            <!-- Sidebar -->
            <div class="w-full md:w-1/4 px-4 mb-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex flex-col items-center text-center mb-6">
                        <div
                            class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 text-3xl mb-3">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h2>
                        <p class="text-gray-600 text-sm">{{ $user->email }}</p>
                    </div>

                    <hr class="my-4">

                    <nav class="space-y-2">
                        <a href="{{ route('profile.dashboard') }}"
                            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-700 transition">
                            <i class="fa-solid fa-tachometer-alt w-5 h-5"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('profile.orders') }}"
                            class="flex items-center space-x-2 p-2 rounded-lg bg-blue-50 text-blue-700">
                            <i class="fa-solid fa-shopping-bag w-5 h-5"></i>
                            <span>My Orders</span>
                        </a>
                        <a href="#"
                            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-700 transition">
                            <i class="fa-solid fa-user-edit w-5 h-5"></i>
                            <span>Account Details</span>
                        </a>
                        <a href="#"
                            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-700 transition">
                            <i class="fa-solid fa-map-marker-alt w-5 h-5"></i>
                            <span>Addresses</span>
                        </a>
                        <form method="GET" action="{{ route('user.logout') }}" class="mt-4">
                            @csrf
                            <button type="submit"
                                class="flex items-center space-x-2 p-2 rounded-lg hover:bg-red-50 text-gray-700 hover:text-red-700 transition w-full">
                                <i class="fa-solid fa-sign-out-alt w-5 h-5"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="w-full md:w-3/4 px-4">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6">My Orders</h1>

                    @if ($orders->count() > 0)
                        <!-- Orders Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                                <thead class="bg-gray-100 border-b border-gray-200">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-gray-600">Order ID</th>
                                        <th class="px-6 py-3 text-left text-gray-600">Status</th>
                                        <th class="px-6 py-3 text-left text-gray-600">Total Price</th>
                                        <th class="px-6 py-3 text-left text-gray-600">Order Date</th>
                                        <th class="px-6 py-3 text-left text-gray-600">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition"
                                            data-order-id="{{ $order->id }}">
                                            <td class="px-6 py-3 text-gray-800">#{{ $order->id }}</td>
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
                                            <td class="px-6 py-3 text-gray-600">${{ number_format($order->total_price, 2) }}
                                            </td>
                                            <td class="px-6 py-3 text-gray-600">
                                                {{ date('d M, Y', strtotime($order->order_date)) }}</td>
                                            <td class="px-12 py-3">
                                                <!-- View Button -->
                                                <button type="button" onclick="openViewModal({{ $order->id }})"
                                                    class="text-blue-500 hover:text-blue-700 transition">
                                                    <i class="fa-solid fa-eye"></i>
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
                    @else
                        <div class="text-center py-12">
                            <div class="text-5xl text-gray-300 mb-4">
                                <i class="fa-solid fa-shopping-bag"></i>
                            </div>
                            <h2 class="text-xl font-semibold text-gray-700 mb-2">No Orders Found</h2>
                            <p class="text-gray-600 mb-6">You haven't placed any orders yet.</p>
                            <a href="{{ route('shop.index') }}"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                Start Shopping
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- View Order Details Modal -->
    <div id="viewOrderModal" class="fixed inset-0 flex items-center justify-center hidden bg-gray-900 bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-3/4 max-w-4xl max-h-[90vh] overflow-y-auto">
            <h2 class="text-xl font-semibold text-gray-800">Order Details</h2>
            <div id="orderDetailsContent" class="mt-4"></div>

            <button type="button" onclick="closeViewModal()"
                class="mt-4 bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                Close
            </button>
        </div>
    </div>

    <!-- JavaScript for View Order Details -->
    <script>
        function openViewModal(orderId) {
            fetch(`{{ url('/profile/orders') }}/${orderId}/details`, {
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
