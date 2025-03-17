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
                <p id="successMessage" class="text-green-600 font-semibold text-center hidden mt-2">Product added successfully!</p>
            </form>
        </div>
    </div>

    <!-- JavaScript for Slug & AJAX -->
    <script>
        // Auto-generate slug from name
        document.getElementById('product_name').addEventListener('input', function() {
            let slug = this.value.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
            document.getElementById('product_slug').value = slug;
        });

        // Show Image Preview
        function previewImage(event) {
            const imagePreview = document.getElementById('image_preview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('hidden'); // Show preview
                };
                reader.readAsDataURL(file);
            }
        }

        // AJAX Form Submission
        document.getElementById('addProductForm').addEventListener('submit', function(event) {
            event.preventDefault();

            let formData = new FormData(this);

            fetch("{{ route('admin.products.store') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('successMessage').classList.remove('hidden');
                        
                        // Reset form after success
                        setTimeout(() => {
                            window.location.href = "{{ route('admin.products') }}";
                        }, 1000);
                    } else if (data.errors) {
                        // Show validation errors
                        for (let key in data.errors) {
                            let errorElement = document.getElementById('error-' + key);
                            if (errorElement) {
                                errorElement.textContent = data.errors[key][0];
                                errorElement.classList.remove('hidden');
                            }
                        }
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
@endsection
