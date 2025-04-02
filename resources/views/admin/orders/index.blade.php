@extends('admin.dashboard')

@section('content')
    <div class="p-4 md:p-10">
        <!-- Page Title -->
        <h2 class="text-2xl md:text-3xl font-bold mb-4 md:mb-6 text-gray-800">Orders</h2>

        <!-- Search Bar - Responsive -->
        <div class="flex justify-between items-center bg-white p-3 md:p-4 rounded-lg shadow-md">
            <input type="text" id="searchInput" placeholder="Search Orders"
                class="border p-2 rounded-md w-full md:w-1/3 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Orders Table - Responsive Design -->
        <div class="mt-4 md:mt-6 bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-3 md:px-6 py-2 md:py-3 text-left text-xs md:text-sm font-medium text-gray-600">
                                Order ID</th>
                            <th class="px-3 md:px-6 py-2 md:py-3 text-left text-xs md:text-sm font-medium text-gray-600">
                                Customer</th>
                            <th class="px-3 md:px-6 py-2 md:py-3 text-left text-xs md:text-sm font-medium text-gray-600">
                                Status</th>
                            <th class="px-3 md:px-6 py-2 md:py-3 text-left text-xs md:text-sm font-medium text-gray-600">
                                Total</th>
                            <th
                                class="hidden md:table-cell px-3 md:px-6 py-2 md:py-3 text-left text-xs md:text-sm font-medium text-gray-600">
                                Date</th>
                            <th class="px-3 md:px-6 py-2 md:py-3 text-left text-xs md:text-sm font-medium text-gray-600">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody id="orderTableBody">
                        @foreach ($orders as $order)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition"
                                data-order-id="{{ $order->id }}">
                                <td class="px-3 md:px-6 py-2 md:py-3 text-xs md:text-sm text-gray-800">#{{ $order->id }}
                                </td>
                                <td
                                    class="px-3 md:px-6 py-2 md:py-3 text-xs md:text-sm text-gray-800 max-w-[80px] md:max-w-none truncate">
                                    {{ $order->user->name ?? 'Guest' }}</td>
                                <td class="px-3 md:px-6 py-2 md:py-3">
                                    <span
                                        class="px-1.5 md:px-2 py-0.5 md:py-1 rounded-lg text-white text-xs md:text-sm
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

                                    <!-- Edit Button -->
                                    {{-- <a href="{{ route('admin.orders.edit', $order->id) }}"
                                        class="text-blue-500 hover:text-blue-700 transition">
                                        <i class="uil uil-edit"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <button type="button"
                                        onclick="openDeleteModal({{ $order->id }}, 'Order #{{ $order->id }}')"
                                        class="text-red-500 hover:text-red-700 transition">
                                        <i class="uil uil-trash-alt"></i>
                                    </button> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>

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
    {{-- <div id="deleteModal" class="fixed inset-0 flex items-center justify-center hidden bg-gray-900 bg-opacity-50">
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
    </div> --}}

    <!-- JavaScript for Delete & View Order Details -->
    <script>
        // AJAX Search Functionality
        $(document).ready(function() {
            let searchTimer;
            $("#searchInput").on("keyup", function() {
                clearTimeout(searchTimer); // Clear any existing timer

                searchTimer = setTimeout(() => {
                    let query = $(this).val().trim(); // Remove extra spaces

                    $.ajax({
                        url: "{{ route('admin.orders.search') }}",
                        type: "GET",
                        data: {
                            q: query
                        },
                        dataType: "json",
                        success: function(data) {
                            $("#orderTableBody").html(data.html);
                        },
                        error: function(xhr, status, error) {
                            console.error("Search Error:", error);
                        }
                    });
                }, 500); // 500ms debounce delay
            });
        });

        function openViewModal(orderId) {
            fetch("{{ route('admin.orders.details', '') }}/" + orderId, {
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

                        // Add event listener to status toggle after modal content is loaded
                        const statusToggle = document.getElementById("orderStatusToggle");
                        if (statusToggle) {
                            statusToggle.addEventListener("change", function() {
                                updateOrderStatus(this.dataset.orderId, this.value);
                            });
                        }
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

        function updateOrderStatus(orderId, newStatus) {
            // Show loading indicator
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            // Send AJAX request to update status
            fetch("{{ url('/admin/orders/update-status') }}/" + orderId, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: JSON.stringify({
                        order_status: newStatus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success notification
                        Toast.fire({
                            icon: 'success',
                            title: 'Order status updated successfully'
                        });

                        // Update the status badge in the modal
                        const statusBadge = document.querySelector('#orderDetailsContent .rounded-lg.text-white');
                        if (statusBadge) {
                            // Remove old status classes
                            statusBadge.classList.remove('bg-yellow-500', 'bg-blue-500', 'bg-green-500', 'bg-red-500');

                            // Add new status class
                            if (newStatus === 'pending') {
                                statusBadge.classList.add('bg-yellow-500');
                            } else if (newStatus === 'shipped') {
                                statusBadge.classList.add('bg-blue-500');
                            } else if (newStatus === 'delivered') {
                                statusBadge.classList.add('bg-green-500');
                            } else {
                                statusBadge.classList.add('bg-red-500');
                            }

                            // Update text
                            statusBadge.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                        }

                        // Also update the status in the main table if the order is visible
                        const tableStatusBadge = document.querySelector(
                            `tr[data-order-id="${orderId}"] .rounded-lg.text-white`);
                        if (tableStatusBadge) {
                            // Remove old status classes
                            tableStatusBadge.classList.remove('bg-yellow-500', 'bg-blue-500', 'bg-green-500',
                                'bg-red-500');

                            // Add new status class
                            if (newStatus === 'pending') {
                                tableStatusBadge.classList.add('bg-yellow-500');
                            } else if (newStatus === 'shipped') {
                                tableStatusBadge.classList.add('bg-blue-500');
                            } else if (newStatus === 'delivered') {
                                tableStatusBadge.classList.add('bg-green-500');
                            } else {
                                tableStatusBadge.classList.add('bg-red-500');
                            }

                            // Update text
                            tableStatusBadge.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                        }
                    } else {
                        // Show error notification
                        Toast.fire({
                            icon: 'error',
                            title: data.error || 'Failed to update order status'
                        });
                    }
                })
                .catch(error => {
                    console.error("Error updating status:", error);
                    // Show error notification
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong while updating status'
                    });
                });
        }
    </script>
@endsection
