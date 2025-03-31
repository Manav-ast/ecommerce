@extends('admin.dashboard')

@section('content')
    <div class="p-4 md:p-10">
        <!-- Page Title -->
        <h2 class="text-2xl md:text-3xl font-bold mb-4 md:mb-6 text-gray-800">Categories</h2>

        <!-- Search and Add Button - Responsive Layout -->
        <div
            class="flex flex-col md:flex-row justify-between gap-3 md:items-center bg-white p-3 md:p-4 rounded-lg shadow-md">
            <div class="flex flex-col md:flex-row md:items-center gap-3 md:space-x-4 w-full md:w-auto">
                <input type="text" id="searchInput" placeholder="Search Categories"
                    class="border p-2 rounded-md w-full md:w-64 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <a href="{{ route('admin.categories.trashed') }}"
                    class="bg-gray-600 text-white px-3 py-2 rounded-md hover:bg-gray-700 transition text-center md:text-left text-sm md:text-base">
                    <i class="uil uil-trash-alt"></i> Trashed Categories
                </a>
            </div>
            <a href="{{ route('admin.categories.create') }}"
                class="bg-green-600 text-white px-3 py-2 rounded-md hover:bg-green-700 transition text-center md:text-left text-sm md:text-base">
                <i class="uil uil-plus"></i> Add Category
            </a>
        </div>

        <!-- Categories Table - Responsive Design -->
        <div class="mt-4 md:mt-6 bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-3 md:px-6 py-2 md:py-3 text-left text-xs md:text-sm font-medium text-gray-600">
                                Image</th>
                            <th class="px-3 md:px-6 py-2 md:py-3 text-left text-xs md:text-sm font-medium text-gray-600">
                                Name</th>
                            <th
                                class="hidden md:table-cell px-3 md:px-6 py-2 md:py-3 text-left text-xs md:text-sm font-medium text-gray-600">
                                Slug</th>
                            <th
                                class="hidden md:table-cell px-3 md:px-6 py-2 md:py-3 text-left text-xs md:text-sm font-medium text-gray-600">
                                Description</th>
                            <th class="px-3 md:px-6 py-2 md:py-3 text-left text-xs md:text-sm font-medium text-gray-600">
                                Products</th>
                            <th class="px-3 md:px-6 py-2 md:py-3 text-left text-xs md:text-sm font-medium text-gray-600">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody id="categoryTable">
                        @foreach ($categories as $category)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="px-3 md:px-6 py-2 md:py-3 relative">
                                    <div class="w-8 h-8 md:w-10 md:h-10 overflow-hidden">
                                        <img src="{{ asset('storage/' . $category->image) }}"
                                            class="w-8 h-8 md:w-10 md:h-10 object-cover rounded transition-transform duration-300 transform hover:scale-150 hover:absolute hover:top-0 hover:left-0 hover:w-20 hover:h-20 md:hover:w-24 md:hover:h-24 hover:shadow-lg">
                                    </div>
                                </td>
                                <td
                                    class="px-3 md:px-6 py-2 md:py-3 text-xs md:text-sm text-gray-800 max-w-[100px] md:max-w-none truncate">
                                    {{ $category->name }}</td>
                                <td
                                    class="hidden md:table-cell px-3 md:px-6 py-2 md:py-3 text-xs md:text-sm text-gray-600 truncate">
                                    {{ $category->slug }}</td>
                                <td class="hidden md:table-cell px-3 md:px-6 py-2 md:py-3 text-xs md:text-sm text-gray-600">
                                    {{ \Illuminate\Support\Str::limit($category->description, 50) }}</td>
                                <td class="px-3 md:px-6 py-2 md:py-3 text-xs md:text-sm text-gray-600">
                                    {{ $category->products_count }}</td>
                                <td class="px-3 md:px-6 py-2 md:py-3 flex space-x-2 md:space-x-4">
                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                                        class="text-blue-500 hover:text-blue-700 transition p-1">
                                        <i class="uil uil-edit"></i>
                                    </a>

                                    <!-- Delete Button (Triggers SweetAlert2) -->
                                    <button type="button"
                                        onclick="openDeleteModal({{ $category->id }}, '{{ $category->name }}')"
                                        class="text-red-500 hover:text-red-700 transition p-1">
                                        <i class="uil uil-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination - Responsive -->
        <div class="mt-4 md:mt-6 px-2 md:px-0">
            {{ $categories->links() }}
        </div>
    </div>

    <!-- SweetAlert2 is loaded in the dashboard layout -->

    <!-- JavaScript for Search & Delete Confirmation Modal -->
    <script>
        $(document).ready(function() {
            // Display flash messages on page load
            if (typeof successMessage !== 'undefined' && successMessage) {
                showSuccessToast(successMessage);
            }

            let searchTimer;
            $("#searchInput").on("keyup", function() {
                clearTimeout(searchTimer); // Clear any existing timer

                searchTimer = setTimeout(() => {
                    let query = $(this).val().trim(); // Remove extra spaces

                    $.ajax({
                        url: "{{ route('admin.categories.search') }}",
                        type: "GET",
                        data: {
                            q: query
                        }, // ✅ Use `q` instead of `search`
                        dataType: "json", // ✅ Expect JSON response
                        success: function(data) {
                            $("#categoryTable").html(data
                                .html); // ✅ Inject new table content
                        },
                        error: function(xhr, status, error) {
                            console.error("Search Error:", error);
                        }
                    });
                }, 500); // 500ms debounce delay
            });
        });

        function openDeleteModal(categoryId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to delete this category. This cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to delete the category
                    $.ajax({
                        url: "/admin/categories/" + categoryId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            // Show success toast message instead of modal
                            showSuccessToast('Category has been deleted successfully!');

                            // Remove the deleted row from the table
                            setTimeout(function() {
                                // Reload the page or remove the row from DOM
                                window.location.reload();
                            }, 1000);
                        },
                        error: function(xhr, status, error) {
                            // Show error toast message
                            showErrorToast('There was a problem deleting the category.');
                            console.error(error);
                        }
                    });
                }
            });
        }
    </script>
@endsection
