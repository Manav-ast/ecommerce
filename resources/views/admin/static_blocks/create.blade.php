@extends('admin.dashboard')

@section('content')
    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-4xl">
            <!-- Page Title -->
            <h2 class="text-2xl font-bold mb-4 text-gray-800 text-center">Add Static Block</h2>

            <!-- Form -->
            <form id="addStaticBlockForm" method="POST">
                @csrf

                <!-- Title -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Title</label>
                    <input type="text" name="title" id="title" required
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter block title">
                    <span class="text-red-500 text-sm hidden" id="error-title"></span>
                </div>

                <!-- Slug -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Slug</label>
                    <input type="text" name="slug" id="slug" required
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Auto-generated slug">
                    <span class="text-red-500 text-sm hidden" id="error-slug"></span>
                </div>

                <!-- Content (Summernote) -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Content</label>
                    <textarea name="content" id="content" required class="w-full p-2 border rounded-lg"></textarea>
                    <span class="text-red-500 text-sm hidden" id="error-content"></span>
                </div>

                <!-- Status -->
                <div class="mb-2">
                    <label class="block text-gray-700 font-semibold mb-1">Status</label>
                    <select name="status" id="status" required
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    <span class="text-red-500 text-sm hidden" id="error-status"></span>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Add Static Block
                </button>
            </form>
        </div>
    </div>
@endsection

<!-- JavaScript for Slug & AJAX -->
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Summernote
            $('#content').summernote({
                height: 300
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
            $("#addStaticBlockForm").validate({
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
                },
                submitHandler: function(form) {
                    let formData = new FormData(form);

                    $.ajax({
                        url: "{{ route('admin.static_blocks.store') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            if (data.success) {
                                showSuccessToast(data.message);
                                setTimeout(() => {
                                    window.location.href = "{{ route('admin.static_blocks.index') }}";
                                }, 1000);
                            } else if (data.errors) {
                                $.each(data.errors, function(key, value) {
                                    $('#error-' + key).text(value[0]).removeClass('hidden');
                                });
                            } else {
                                showErrorToast('An error occurred.');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            showErrorToast('An error occurred.');
                        }
                    });
                }
            });
        });
    </script>
@endpush

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css" rel="stylesheet">
@endpush
