@extends('admin.dashboard')

@section('content')
<div class="flex justify-center items-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
        <!-- Page Title -->
        <h2 class="text-2xl font-bold mb-4 text-gray-800 text-center">Edit Category</h2>

        <!-- Form -->
        <form id="editCategoryForm" action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
            @csrf
            @method('PUT')

            <!-- Category Name -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Category Name</label>
                <input type="text" name="name" id="category_name" value="{{ $category->name }}" required
                    class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter category name">
            </div>

            <!-- Slug (Editable) -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Slug</label>
                <input type="text" name="slug" id="category_slug" value="{{ $category->slug }}" required
                    class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Auto-generated slug">
            </div>

            <!-- Category Description -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Description</label>
                <textarea name="description" rows="2"
                    class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter category description">{{ $category->description }}</textarea>
            </div>

            <!-- Category Image Upload with Preview -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Upload Image</label>
                <input type="file" name="image" id="category_image"
                    class="w-full p-2 border rounded-lg focus:outline-none" onchange="previewImage(event)">

                <!-- Image Preview -->
                <div class="mt-2 flex justify-center">
                    <img id="image_preview" src="{{ $category->image ? asset('storage/' . $category->image) : '' }}" 
                         class="h-20 w-20 object-cover rounded {{ $category->image ? '' : 'hidden' }}">
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                Update Category
            </button>
        </form>
    </div>
</div>

<!-- JavaScript for Slug & Image Preview -->
<script>
    $(document).ready(function () {
        // Auto-generate slug from name
        $("#category_name").on("input", function () {
            let slug = $(this).val().toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
            $("#category_slug").val(slug);
        });

        // Show Image Preview
        function previewImage(event) {
            const imagePreview = $("#image_preview");
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.attr("src", e.target.result).removeClass("hidden");
                };
                reader.readAsDataURL(file);
            }
        }
        window.previewImage = previewImage; // Make function global for onchange event
    });
</script>

@endsection
