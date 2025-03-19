@extends('admin.dashboard')

@section('content')
    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
            <!-- Page Title -->
            <h2 class="text-2xl font-bold mb-4 text-gray-800 text-center">Add Product</h2>

            <!-- Form -->
            <form id="addProductForm" enctype="multipart/form-data" class="space-y-3">
                @csrf

                <!-- Product Name -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Product Name</label>
                    <input type="text" name="name" id="product_name" required
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter product name">
                    <span class="text-red-500 text-sm hidden" id="error-name"></span>
                </div>

                <!-- Slug -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Slug</label>
                    <input type="text" name="slug" id="product_slug" required
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Auto-generated slug">
                    <span class="text-red-500 text-sm hidden" id="error-slug"></span>
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Price ($)</label>
                    <input type="number" name="price" step="0.01" required
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter product price">
                    <span class="text-red-500 text-sm hidden" id="error-price"></span>
                </div>

                <!-- Stock Quantity -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Stock Quantity</label>
                    <input type="number" name="stock_quantity" required
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter stock quantity">
                    <span class="text-red-500 text-sm hidden" id="error-stock_quantity"></span>
                </div>

                <!-- Category Selection -->

                {{-- @php
                    dd($categories);
                @endphp --}}
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Category</label>
                    <select name="categories[]" multiple required
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-red-500 text-sm hidden" id="error-categories"></span>
                </div>

                <!-- Product Image Upload with Preview -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Upload Image</label>
                    <input type="file" name="image" id="product_image" required
                        class="w-full p-2 border rounded-lg focus:outline-none" onchange="previewImage(event)">
                    <span class="text-red-500 text-sm hidden" id="error-image"></span>

                    <!-- Image Preview -->
                    <div class="mt-2 flex justify-center">
                        <img id="image_preview" src="" class="h-20 w-20 object-cover rounded hidden">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Add Product
                </button>

                <!-- Success Message -->
                <p id="successMessage" class="text-green-600 font-semibold text-center hidden mt-2">Product added
                    successfully!</p>
            </form>
        </div>
    </div>
@endsection
<!-- JavaScript for Slug & AJAX -->
@push('scripts')
    <script>
        $(document).ready(function() {
            // Auto-generate slug from name
            $('#product_name').on('input', function() {
                let slug = $(this).val().toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
                $('#product_slug').val(slug);
            });

            // Show Image Preview
            $('#product_image').on('change', function(event) {
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#image_preview').attr('src', e.target.result).removeClass('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Clear validation errors when input changes
            $('input, select').on('input change', function() {
                let errorId = 'error-' + $(this).attr('name').replace('[]', '');
                $('#' + errorId).addClass('hidden');
            });

            // Initialize jQuery Validator
            $("#addProductForm").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 255
                    },
                    slug: {
                        required: true,
                        maxlength: 255
                    },
                    price: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    stock_quantity: {
                        required: true,
                        digits: true,
                        min: 0
                    },
                    image: {
                        required: true,
                        extension: "jpeg|jpg|png|gif"
                    },
                    "categories[]": {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter a product name",
                        maxlength: "Product name cannot exceed 255 characters"
                    },
                    slug: {
                        required: "Slug is required",
                        maxlength: "Slug cannot exceed 255 characters"
                    },
                    price: {
                        required: "Please enter a price",
                        number: "Please enter a valid price",
                        min: "Price must be greater than or equal to 0"
                    },
                    stock_quantity: {
                        required: "Please enter stock quantity",
                        digits: "Stock quantity must be a whole number",
                        min: "Stock quantity must be greater than or equal to 0"
                    },
                    image: {
                        required: "Please select an image",
                        extension: "Please select a valid image file (jpeg, jpg, png, gif)"
                    },
                    "categories[]": {
                        required: "Please select at least one category"
                    }
                },
                errorPlacement: function(error, element) {
                    // Custom error placement - use existing error spans
                    let name = element.attr("name").replace('[]', '');
                    $("#error-" + name).html(error.text()).removeClass('hidden');
                },
                submitHandler: function(form) {
                    // AJAX Form Submission using jQuery
                    let formData = new FormData(form);

                    $.ajax({
                        url: "{{ route('admin.products.store') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            if (data.success) {
                                $('#successMessage').removeClass('hidden');

                                // Reset form after success
                                setTimeout(function() {
                                    window.location.href =
                                        "{{ route('admin.products') }}";
                                }, 1000);
                            } else if (data.errors) {
                                // Show validation errors
                                $.each(data.errors, function(key, value) {
                                    $('#error-' + key).text(value[0]).removeClass(
                                        'hidden');
                                });
                            } else {
                                alert('Error: ' + data.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
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
