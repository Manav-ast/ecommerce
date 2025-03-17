@extends('admin.dashboard')

@section('content')
    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
            <!-- Page Title -->
            <h2 class="text-2xl font-bold mb-4 text-gray-800 text-center">Edit Product</h2>

            <!-- Form -->
            <form id="editProductForm" action="{{ route('admin.products.update', ['id' => $product->id]) }}" method="POST"
                enctype="multipart/form-data" class="space-y-3">

                @csrf
                @method('PUT')

                <!-- Product Name -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Product Name</label>
                    <input type="text" name="name" id="product_name" value="{{ $product->name }}" required
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter product name">
                </div>

                <!-- Slug -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Slug</label>
                    <input type="text" name="slug" id="product_slug" value="{{ $product->slug }}" required
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Auto-generated slug">
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Price ($)</label>
                    <input type="number" name="price" step="0.01" value="{{ $product->price }}" required
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter product price">
                </div>

                <!-- Stock Quantity -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Stock Quantity</label>
                    <input type="number" name="stock_quantity" value="{{ $product->stock_quantity }}" required
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter stock quantity">
                </div>

                <!-- Category Selection -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Category</label>
                    <select name="categories[]" multiple required
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ in_array($category->id, $product->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Product Image Upload with Preview -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Upload Image</label>
                    <input type="file" name="image" id="product_image"
                        class="w-full p-2 border rounded-lg focus:outline-none" onchange="previewImage(event)">

                    <!-- Image Preview -->
                    <div class="mt-2 flex justify-center">
                        <img id="image_preview"
                            src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/default-product.png') }}"
                            class="h-20 w-20 object-cover rounded">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Update Product
                </button>
            </form>
        </div>
    </div>

    <!-- JavaScript for Slug & Image Preview -->
    <script>
        $(document).ready(function() {
            // Auto-generate slug from name
            $("#product_name").on("input", function() {
                let slug = $(this).val().toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
                $("#product_slug").val(slug);
            });

            // Show Image Preview
            function previewImage(event) {
                const imagePreview = $("#image_preview");
                const file = event.target.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.attr("src", e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
            window.previewImage = previewImage; // Make function global for onchange event
        });
    </script>
@endsection
