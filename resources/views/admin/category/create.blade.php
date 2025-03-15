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
                    <input type="text" name="name" id="category_name" required
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter category name">
                </div>

                <!-- Slug (Editable) -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Slug</label>
                    <input type="text" name="slug" id="category_slug" required
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Auto-generated slug">
                </div>

                <!-- Category Description -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Description</label>
                    <textarea name="description" rows="2"
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter category description"></textarea>
                </div>

                <!-- Category Image Upload with Preview -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Upload Image</label>
                    <input type="file" name="image" id="category_image" required
                        class="w-full p-2 border rounded-lg focus:outline-none" onchange="previewImage(event)">

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

    <!-- JavaScript for Slug & AJAX -->
    <script>
        // Auto-generate slug from name
        document.getElementById('category_name').addEventListener('input', function() {
            let slug = this.value.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
            document.getElementById('category_slug').value = slug;
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
        document.getElementById('addCategoryForm').addEventListener('submit', function(event) {
            event.preventDefault();

            let formData = new FormData(this);

            fetch("{{ route('admin.categories.store') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Redirect to categories page after 1 second
                        setTimeout(() => {
                            window.location.href = "{{ route('admin.categories') }}";
                        }, 1000);
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
@endsection
