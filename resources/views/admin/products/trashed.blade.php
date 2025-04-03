@extends('admin.dashboard')

@section('content')
    <div class="p-10">
        <!-- Page Title -->
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Trashed Products</h2>

        <!-- Back to Products and Other Actions -->
        <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-md mb-6">
            <a href="{{ route('admin.products') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                <i class="uil uil-arrow-left"></i> Back to Products
            </a>
        </div>

        <!-- Trashed Products Table -->
        <div class="mt-6 bg-white shadow-md rounded-lg overflow-auto">
            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-gray-600">Image</th>
                        <th class="px-6 py-3 text-left text-gray-600">Name</th>
                        <th class="px-6 py-3 text-left text-gray-600">Slug</th>
                        <th class="px-6 py-3 text-left text-gray-600">Price</th>
                        <th class="px-6 py-3 text-left text-gray-600">Stock</th>
                        <th class="px-6 py-3 text-left text-gray-600">Category</th>
                        <th class="px-6 py-3 text-left text-gray-600">Deleted At</th>
                        <th class="px-6 py-3 text-left text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($products->count() > 0)
                        @foreach ($products as $product)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="px-6 py-3 relative">
                                    <div class="w-10 h-10 overflow-hidden">
                                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/default-product.png') }}"
                                            class="w-10 h-10 object-cover rounded">
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-gray-800">{{ $product->name }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $product->slug }}</td>
                                <td class="px-6 py-3 text-gray-600">${{ number_format($product->price, 2) }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $product->stock_quantity }}</td>
                                <td class="px-6 py-3 text-gray-600">
                                    @if ($product->categories->isNotEmpty())
                                        {{ $product->categories->pluck('name')->join(', ') }}
                                    @else
                                        <span class="text-gray-400 italic">No Category</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-gray-600">{{ $product->deleted_at->format('Y-m-d H:i') }}</td>
                                <td class="px-6 py-3 flex space-x-4">
                                    <!-- Restore Button -->
                                    <button type="button"
                                        onclick="openRestoreModal({{ $product->id }}, '{{ $product->name }}')"
                                        class="text-green-500 hover:text-green-700 transition">
                                        <i class="uil uil-redo"></i>
                                    </button>

                                    <!-- Permanent Delete Button -->
                                    <button type="button"
                                        onclick="openForceDeleteModal({{ $product->id }}, '{{ $product->name }}')"
                                        class="text-red-500 hover:text-red-700 transition">
                                        <i class="uil uil-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">No trashed products found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>

    <!-- JavaScript for Restore and Force Delete -->
    <script>
        function openRestoreModal(productId, productName) {
            Swal.fire({
                title: 'Restore Product',
                text: "Are you sure you want to restore '" + productName + "'?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, restore it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = $('<form>', {
                        method: 'POST',
                        action: "{{ url('/admin/products') }}/" + productId + "/restore"
                    });

                    form.append($('<input>', {
                        type: 'hidden',
                        name: '_token',
                        value: '{{ csrf_token() }}'
                    }));

                    $('body').append(form);
                    form.submit();
                }
            });
        }

        function openForceDeleteModal(productId, productName) {
            Swal.fire({
                title: 'Permanently Delete',
                text: "You are about to permanently delete '" + productName + "'. This action CANNOT be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete permanently!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = $('<form>', {
                        method: 'POST',
                        action: "{{ url('/admin/products') }}/" + productId + "/force-delete"
                    });

                    form.append($('<input>', {
                        type: 'hidden',
                        name: '_token',
                        value: '{{ csrf_token() }}'
                    }));

                    form.append($('<input>', {
                        type: 'hidden',
                        name: '_method',
                        value: 'DELETE'
                    }));

                    $('body').append(form);
                    form.submit();
                }
            });
        }
    </script>

@endsection
