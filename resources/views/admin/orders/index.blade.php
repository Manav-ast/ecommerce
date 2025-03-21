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
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition"
                            data-order-id="{{ $order->id }}">
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
                            <td class="px-12 py-3">
                                <!-- View Button -->
                                <button type="button" data-order-id="{{ $order->id }}"
                                    class="view-order-btn text-green-500 hover:text-green-700 transition">
                                    <i class="uil uil-eye"></i>
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


    {{-- <!-- Delete Confirmation Modal -->
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
    </div> --}}

    <!-- JavaScript for Delete & View Order Details -->
    <script>
        $(document).ready(function() {
            // View order button click event
            $(document).on('click', '.view-order-btn', function() {
                const orderId = $(this).data('order-id');

                $.ajax({
                    url: "{{ url('/admin/orders/details') }}/" + orderId,
                    method: "GET",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    success: function(data) {
                        if (data.html) {
                            $("#orderDetailsContent").html(data.html);
                            $("#viewOrderModal").removeClass("hidden");

                            // Add event listener to status toggle after modal content is loaded
                            $("#orderStatusToggle").on('change', function() {
                                updateOrderStatus($(this).data('order-id'), $(this)
                                .val());
                            });
                        } else {
                            $("#orderDetailsContent").html(
                                "<p class='text-red-500'>Order details not found.</p>");
                            $("#viewOrderModal").removeClass("hidden");
                        }
                    },
                    error: function(error) {
                        console.error("Ajax error:", error);
                        $("#orderDetailsContent").html(
                            "<p class='text-red-500'>Something went wrong.</p>");
                        $("#viewOrderModal").removeClass("hidden");
                    }
                });
            });

            // Close modal button click event
            $(document).on('click', '[onclick="closeViewModal()"]', function() {
                $("#viewOrderModal").addClass("hidden");
            });
        });

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
            $.ajax({
                url: "{{ url('/admin/orders/update-status') }}/" + orderId,
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "X-Requested-With": "XMLHttpRequest"
                },
                contentType: "application/json",
                data: JSON.stringify({
                    order_status: newStatus
                }),
                success: function(data) {
                    if (data.success) {
                        // Show success notification
                        Toast.fire({
                            icon: 'success',
                            title: 'Order status updated successfully'
                        });

                        // Update the status badge in the modal
                        const $statusBadge = $('#orderDetailsContent .rounded-lg.text-white');
                        if ($statusBadge.length) {
                            // Remove old status classes
                            $statusBadge.removeClass('bg-yellow-500 bg-blue-500 bg-green-500 bg-red-500');

                            // Add new status class
                            if (newStatus === 'pending') {
                                $statusBadge.addClass('bg-yellow-500');
                            } else if (newStatus === 'shipped') {
                                $statusBadge.addClass('bg-blue-500');
                            } else if (newStatus === 'delivered') {
                                $statusBadge.addClass('bg-green-500');
                            } else {
                                $statusBadge.addClass('bg-red-500');
                            }

                            // Update text
                            $statusBadge.text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1));
                        }

                        // Also update the status in the main table if the order is visible
                        const $tableStatusBadge = $("tr[data-order-id='" + orderId +
                            "'] .rounded-lg.text-white");
                        if ($tableStatusBadge.length) {
                            // Remove old status classes
                            $tableStatusBadge.removeClass('bg-yellow-500 bg-blue-500 bg-green-500 bg-red-500');

                            // Add new status class
                            if (newStatus === 'pending') {
                                $tableStatusBadge.addClass('bg-yellow-500');
                            } else if (newStatus === 'shipped') {
                                $tableStatusBadge.addClass('bg-blue-500');
                            } else if (newStatus === 'delivered') {
                                $tableStatusBadge.addClass('bg-green-500');
                            } else {
                                $tableStatusBadge.addClass('bg-red-500');
                            }

                            // Update text
                            $tableStatusBadge.text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1));
                        }
                    } else {
                        // Show error notification
                        Toast.fire({
                            icon: 'error',
                            title: data.error || 'Failed to update order status'
                        });
                    }
                },
                error: function(error) {
                    console.error("Error updating status:", error);
                    // Show error notification
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong while updating status'
                    });
                }
            });
        }
    </script>
@endsection
