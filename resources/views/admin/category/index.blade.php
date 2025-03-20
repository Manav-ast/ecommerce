@extends('admin.dashboard')

@section('content')
    <div class="p-10">
        <!-- Page Title -->
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Categories</h2>

        <!-- Search and Add Button -->
        <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-md">
            <input type="text" id="searchInput" placeholder="Search Categories"
                class="border p-2 rounded-md w-1/3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <a href="{{ route('admin.categories.create') }}"
                class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                <i class="uil uil-plus"></i> Category
            </a>
        </div>

        <!-- Categories Table -->
        <div class="mt-6 bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-gray-600">Image</th>
                        <th class="px-6 py-3 text-left text-gray-600">Name</th>
                        <th class="px-6 py-3 text-left text-gray-600">Slug</th>
                        <th class="px-6 py-3 text-left text-gray-600">Description</th>
                        <th class="px-6 py-3 text-left text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody id="categoryTable">
                    @foreach ($categories as $category)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                            <td class="px-6 py-3 relative">
                                <div class="w-10 h-10 overflow-hidden">
                                    <img src="{{ asset('storage/' . $category->image) }}"
                                        class="w-10 h-10 object-cover rounded transition-transform duration-300 transform hover:scale-150 hover:absolute hover:top-0 hover:left-0 hover:w-24 hover:h-24 hover:shadow-lg">
                                </div>
                            </td>
                            <td class="px-6 py-3 text-gray-800">{{ $category->name }}</td>
                            <td class="px-6 py-3 text-gray-600">{{ $category->slug }}</td>
                            <td class="px-6 py-3 text-gray-600">
                                {{ \Illuminate\Support\Str::limit($category->description, 50) }}</td>
                            <td class="px-6 py-3 flex space-x-4">
                                <!-- Edit Button -->
                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                    class="text-blue-500 hover:text-blue-700 transition">
                                    <i class="uil uil-edit"></i>
                                </a>

                                <!-- Delete Button (Triggers Modal) -->
                                <button type="button" onclick="openDeleteModal({{ $category->id }})"
                                    class="text-red-500 hover:text-red-700 transition">
                                    <i class="uil uil-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center hidden bg-gray-900 bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-semibold text-gray-800">Confirm Deletion</h2>
            <p class="text-gray-600 mt-2">Are you sure you want to delete this category?</p>

            <!-- Form -->
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

    <!-- JavaScript for Search & Delete Confirmation Modal -->
    <script>
        $(document).ready(function() {
            $("#searchInput").on("keyup", function() {
                let query = $(this).val().trim(); // Remove extra spaces

                $.ajax({
                    url: "{{ route('admin.categories.search') }}",
                    type: "GET",
                    data: {
                        q: query
                    }, // ✅ Use `q` instead of `search`
                    dataType: "json", // ✅ Expect JSON response
                    success: function(data) {
                        $("#categoryTable").html(data.html); // ✅ Inject new table content
                    },
                    error: function(xhr, status, error) {
                        console.error("Search Error:", error);
                    }
                });
            });
        });

        function openDeleteModal(categorySlug) {
            document.getElementById("deleteForm").action = "/admin/categories/" + categorySlug;
            document.getElementById("deleteModal").classList.remove("hidden");
        }

        function closeDeleteModal() {
            document.getElementById("deleteModal").classList.add("hidden");
        }
    </script>
@endsection
