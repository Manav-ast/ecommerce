@extends('admin.dashboard')

@section('content')
    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
            <!-- Page Title -->
            <h2 class="text-2xl font-bold mb-4 text-gray-800 text-center">Add Category</h2>

            <!-- Form -->
            <form id="addCategoryForm" enctype="multipart/form-data" class="space-y-3">
                @csrf

                <!-- Category Name -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Category Name</label>
                    <input type="text" name="name" id="category_name"
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter category name">
                    <span class="text-red-500 text-sm hidden" id="error-name"></span>
                </div>

                <!-- Slug -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Slug</label>
                    <input type="text" name="slug" id="category_slug"
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Auto-generated slug">
                    <span class="text-red-500 text-sm hidden" id="error-slug"></span>
                </div>

                <!-- Category Description -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Description</label>
                    <textarea name="description" id="category_description" rows="2"
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter category description"></textarea>
                    <span class="text-red-500 text-sm hidden" id="error-description"></span>
                </div>

                <!-- Category Image Upload with Preview -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Upload Image</label>
                    <input type="file" name="image" id="category_image"
                        class="w-full p-2 border rounded-lg focus:outline-none" accept="image/*">

                    <span class="text-red-500 text-sm hidden" id="error-image"></span>

                    <!-- Image Preview -->
                    <div class="mt-2 flex justify-center">
                        <img id="image_preview" src="" class="h-20 w-20 object-cover rounded hidden">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Add Category
                </button>

                <!-- Success Message -->
                <p id="successMessage" class="text-green-600 font-semibold text-center hidden mt-2">Category added
                    successfully!</p>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Auto-generate slug from category name
            $('#category_name').on('input', function() {
                let slug = $(this).val().toLowerCase().replace(/\s+/g, '-').replace(/[^\w-]+/g, '');
                $('#category_slug').val(slug);
            });

            // Show Image Preview
            $('#category_image').on('change', function() {
                let file = this.files[0];

                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $('#image_preview').attr('src', e.target.result).removeClass('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Clear validation errors when input changes
            $('input, textarea').on('input change', function() {
                let errorId = 'error-' + $(this).attr('name');
                $('#' + errorId).addClass('hidden');
            });

            // jQuery Validation
            $("#addCategoryForm").validate({
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
                        required: true,
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
                        required: "Please select an image",
                        extension: "Please select a valid image file (jpeg, jpg, png, gif)"
                    }
                },
                errorPlacement: function(error, element) {
                    // Custom error placement - use existing error spans
                    let name = element.attr("name");
                    $("#error-" + name).html(error.text()).removeClass('hidden');
                },
                submitHandler: function(form) {
                    // AJAX Form Submission using jQuery
                    let formData = new FormData(form);

                    $.ajax({
                        url: "{{ route('admin.categories.store') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            if (data.success) {
                                // Show success toast notification
                                showSuccessToast(data.message);

                                // Reset form after success
                                setTimeout(function() {
                                    window.location.href =
                                        "{{ route('admin.categories') }}";
                                }, 1000);
                            } else if (data.errors) {
                                // Show validation errors
                                $.each(data.errors, function(key, value) {
                                    $('#error-' + key).text(value[0]).removeClass(
                                        'hidden');
                                });
                            } else {
                                // Show error toast notification
                                showErrorToast(data.message ||
                                    'An error occurred while adding the category.');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            // Show error toast notification
                            showErrorToast(
                                'An error occurred while processing your request.');
                        }
                    });
                }
            });

            // Add additional method for file extension validation
            $.validator.addMethod("extension", function(value, element, param) {
                param = typeof param === "string" ? param.replace(/,/g, "|") : "png|jpe?g|gif";
                return this.optional(element) || value.match(new RegExp("\\.(" + param + ")$", "i"));
            }, "Please select a valid file with the correct extension.");
        });
    </script>
@endpush
