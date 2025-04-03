@extends('admin.dashboard')

@section('content')
    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-4xl"> <!-- Wider form -->
            <!-- Page Title -->
            <h2 class="text-2xl font-bold mb-4 text-gray-800 text-center">Edit Static Block</h2>

            <!-- Form -->
            <form id="editStaticBlockForm" action="{{ route('admin.static-blocks.update', $staticBlock->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Title</label>
                    <input type="text" name="title" id="title" value="{{ $staticBlock->title }}" required
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter block title">
                    <span class="text-red-500 text-sm hidden" id="error-title"></span>
                </div>

                <!-- Slug -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ $staticBlock->slug }}" required
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Auto-generated slug">
                    <span class="text-red-500 text-sm hidden" id="error-slug"></span>
                </div>

                <!-- Content (Summernote) -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Content</label>
                    <textarea name="content" id="content" required class="w-full p-2 border rounded-lg">{{ $staticBlock->content }}</textarea>
                    <span class="text-red-500 text-sm hidden" id="error-content"></span>
                </div>

                <!-- Status -->
                <div class="mb-2">
                    <label class="block text-gray-700 font-semibold mb-1">Status</label>
                    <select name="status" id="status" required
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="active" {{ $staticBlock->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $staticBlock->status == 'inactive' ? 'selected' : '' }}>Inactive
                        </option>
                    </select>
                    <span class="text-red-500 text-sm hidden" id="error-status"></span>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Update Static Block
                </button>
            </form>
        </div>
    </div>
@endsection

<!-- JavaScript for Slug & Validation -->
@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Summernote
            $('#content').summernote({
                height: 300,
            });

            // Auto-generate slug from title
            $('#title').on('input', function() {
                let slug = $(this).val().toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
                $('#slug').val(slug);
            });

            // Clear validation errors on input change
            $('input, select, textarea').on('input change', function() {
                let errorId = 'error-' + $(this).attr('name');
                $('#' + errorId).addClass('hidden');
            });

            // Initialize jQuery Validator
            $("#editStaticBlockForm").validate({
                rules: {
                    title: {
                        required: true,
                        maxlength: 255
                    },
                    slug: {
                        required: true,
                        maxlength: 255
                    },
                    content: {
                        required: true
                    },
                    status: {
                        required: true
                    }
                },
                messages: {
                    title: {
                        required: "Please enter a title",
                        maxlength: "Title cannot exceed 255 characters"
                    },
                    slug: {
                        required: "Slug is required",
                        maxlength: "Slug cannot exceed 255 characters"
                    },
                    content: {
                        required: "Content is required"
                    },
                    status: {
                        required: "Please select a status"
                    }
                },
                errorPlacement: function(error, element) {
                    let name = element.attr("name");
                    $("#error-" + name).html(error.text()).removeClass('hidden');
                }
            });
        });
    </script>
@endpush
