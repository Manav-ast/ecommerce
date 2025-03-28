@extends('admin.dashboard')

@section('content')
    <div class="p-10">
        <!-- Page Title -->
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Trashed Categories</h2>

        <!-- Back to Categories Button -->
        <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-md mb-6">
            <a href="{{ route('admin.categories') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                <i class="uil uil-arrow-left"></i> Back to Categories
            </a>
        </div>

        <!-- Trashed Categories Table -->
        <div class="mt-6 bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-gray-600">Image</th>
                        <th class="px-6 py-3 text-left text-gray-600">Name</th>
                        <th class="px-6 py-3 text-left text-gray-600">Slug</th>
                        <th class="px-6 py-3 text-left text-gray-600">Description</th>
                        <th class="px-6 py-3 text-left text-gray-600">Deleted At</th>
                        <th class="px-6 py-3 text-left text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($categories->count() > 0)
                        @foreach ($categories as $category)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="px-6 py-3 relative">
                                    <div class="w-10 h-10 overflow-hidden">
                                        <img src="{{ asset('storage/' . $category->image) }}"
                                            class="w-10 h-10 object-cover rounded">
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-gray-800">{{ $category->name }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $category->slug }}</td>
                                <td class="px-6 py-3 text-gray-600">
                                    {{ \Illuminate\Support\Str::limit($category->description, 50) }}
                                </td>
                                <td class="px-6 py-3 text-gray-600">{{ $category->deleted_at->format('Y-m-d H:i') }}</td>
                                <td class="px-6 py-3 flex space-x-4">
                                    <!-- Restore Button -->
                                    <button type="button"
                                        onclick="restoreCategory({{ $category->id }}, '{{ $category->name }}')"
                                        class="text-green-500 hover:text-green-700 transition">
                                        <i class="uil uil-redo"></i>
                                    </button>

                                    <!-- Permanent Delete Button -->
                                    <button type="button"
                                        onclick="forceDeleteCategory({{ $category->id }}, '{{ $category->name }}')"
                                        class="text-red-500 hover:text-red-700 transition">
                                        <i class="uil uil-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No trashed categories found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $categories->links() }}
        </div>
    </div>

    <!-- JavaScript for Restore and Force Delete -->
    <script>
        function restoreCategory(categoryId, categoryName) {
            Swal.fire({
                title: 'Restore Category',
                text: "Are you sure you want to restore '" + categoryName + "'?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, restore it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create form element
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = "{{ url('/admin/categories') }}/" + categoryId + "/restore";

                    // Add CSRF token
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    // Append form to body and submit
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function forceDeleteCategory(categoryId, categoryName) {
            Swal.fire({
                title: 'Permanently Delete',
                text: "You are about to permanently delete '" + categoryName + "'. This action CANNOT be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete permanently!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create form element
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = "{{ url('/admin/categories') }}/" + categoryId + "/force-delete";

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
    </script>
@endsection
