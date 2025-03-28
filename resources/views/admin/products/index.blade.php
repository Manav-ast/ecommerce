@extends('admin.dashboard')

@section('content')
    <div class="p-10">
        <!-- Page Title -->
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Products</h2>

        <!-- Search and Add Button -->
        <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-md">
            <div class="flex items-center space-x-4">
                <input type="text" id="searchInput" placeholder="Search Products"
                    class="border p-2 rounded-md w-64 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <a href="{{ route('admin.products.trashed') }}"
                    class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">
                    <i class="uil uil-trash-alt"></i> Trashed Products
                </a>
            </div>
            <a href="{{ route('admin.products.create') }}"
                class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                <i class="uil uil-plus"></i> Product
            </a>
        </div>

        <!-- Products Table -->
        <div class="mt-6 bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-gray-600">Image</th>
                        <th class="px-6 py-3 text-left text-gray-600">Name</th>
                        <th class="px-6 py-3 text-left text-gray-600">Slug</th>
                        <th class="px-6 py-3 text-left text-gray-600">Price</th>
                        <th class="px-6 py-3 text-left text-gray-600">Stock</th>
                        <th class="px-6 py-3 text-left text-gray-600">Category</th> <!-- NEW -->
                        <th class="px-6 py-3 text-left text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody id="productTableBody">
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
                            <td class="px-6 py-3 flex space-x-4">
                                <!-- Edit Button -->
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                    class="text-blue-500 hover:text-blue-700 transition">
                                    <i class="uil uil-edit"></i>
                                </a>

                                <!-- Delete Button (Triggers Modal) -->
                                <button type="button"
                                    onclick="openDeleteModal({{ $product->id }}, '{{ $product->name }}')"
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
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>

    <!-- SweetAlert2 is loaded in the dashboard layout -->

    <!-- JavaScript for SweetAlert2 Delete Confirmation & Search -->
    <script>
        function openDeleteModal(productId, productName) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to delete '" + productName + "'. This cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create form element
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = "{{ url('/admin/products') }}/" + productId;

                    // Add CSRF token
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    // Add method field
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    form.appendChild(methodField);

                    // Append form to body and submit
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // AJAX Search Functionality
        let searchTimer;
        document.getElementById("searchInput").addEventListener("keyup", function() {
            clearTimeout(searchTimer); // Clear any existing timer

            searchTimer = setTimeout(() => {

                let query = this.value;

                fetch("{{ route('admin.products.search') }}?q=" + encodeURIComponent(query), {
                        method: "GET",
                        headers: {
                            "X-Requested-With": "XMLHttpRequest" // Tell Laravel it's an AJAX request
                        }
                    })
                    .then(response => response.json()) // Expect JSON response
                    .then(data => {
                        document.getElementById("productTableBody").innerHTML = data
                            .html; // Inject HTML response
                    })
                    .catch(error => console.error("Fetch error:", error));
            }, 500); // 500ms debounce delay
        });
    </script>
@endsection
