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
                <span class="text-red-500 text-sm hidden" id="error-name"></span>
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Slug (Editable) -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Slug</label>
                <input type="text" name="slug" id="category_slug" value="{{ $category->slug }}" required
                    class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Auto-generated slug">
                <span class="text-red-500 text-sm hidden" id="error-slug"></span>
                @error('slug')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Category Description -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Description</label>
                <textarea name="description" rows="2"
                    class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter category description">{{ $category->description }}</textarea>
                <span class="text-red-500 text-sm hidden" id="error-description"></span>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Category Image Upload with Preview -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Upload Image</label>
                <input type="file" name="image" id="category_image"
                    class="w-full p-2 border rounded-lg focus:outline-none" onchange="previewImage(event)">
                <span class="text-red-500 text-sm hidden" id="error-image"></span>

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

            <!-- Success Message -->
            <p id="successMessage" class="text-green-600 font-semibold text-center hidden mt-2">Category updated successfully!</p>
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

        // Clear validation errors when input changes
        $('input, textarea').on('input change', function() {
            let errorId = 'error-' + $(this).attr('name');
            $('#' + errorId).addClass('hidden');
        });

        // jQuery Validation
        $("#editCategoryForm").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255
                },
                slug: {
                    required: true,
                    maxlength: 255
                },
                description: {
                    maxlength: 500
                },
                image: {
                    extension: "jpeg|jpg|png|gif"
                }
            },
            messages: {
                name: {
                    required: "Please enter a category name",
                    maxlength: "Category name cannot exceed 255 characters"
                },
                slug: {
                    required: "Slug is required",
                    maxlength: "Slug cannot exceed 255 characters"
                },
                description: {
                    maxlength: "Description cannot exceed 500 characters"
                },
                image: {
                    extension: "Please select a valid image file (jpeg, jpg, png, gif)"
                }
            },
            errorPlacement: function(error, element) {
                // Custom error placement - use existing error spans
                let name = element.attr("name");
                $("#error-" + name).html(error.text()).removeClass('hidden');
            }
        });

        // Add additional method for file extension validation
        $.validator.addMethod("extension", function(value, element, param) {
            param = typeof param === "string" ? param.replace(/,/g, "|") : "png|jpe?g|gif";
            return this.optional(element) || value.match(new RegExp("\\.(" + param + ")$", "i"));
        }, "Please select a valid file with the correct extension.");

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
