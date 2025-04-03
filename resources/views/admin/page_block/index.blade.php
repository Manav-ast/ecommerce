@extends('admin.dashboard')

@section('content')
    <div class="p-4 md:p-10">
        <!-- Page Title -->
        <h2 class="text-2xl md:text-3xl font-bold mb-4 md:mb-6 text-gray-800">Page Blocks</h2>

        <!-- Search and Add Button -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-white p-4 rounded-lg shadow-md">
            <input type="text" id="searchInput" placeholder="Search Page Blocks"
                class="border p-2 rounded-md w-full md:w-1/3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <a href="{{ route('admin.page-blocks.create') }}"
                class="w-full md:w-auto bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition text-center">
                <i class="uil uil-plus"></i> Page Block
            </a>
        </div>

        <!-- Desktop Table View -->
        <div class="hidden md:block mt-6 bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-gray-600">Title</th>
                        <th class="px-6 py-3 text-left text-gray-600">Slug</th>
                        <th class="px-6 py-3 text-left text-gray-600">Status</th>
                        <th class="px-6 py-3 text-left text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody id="staticBlockTableBody">
                    @foreach ($pageBlocks as $block)
                        <tr id="row-{{ $block->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition">
                            <td class="px-6 py-3 text-gray-800">{{ $block->title }}</td>
                            <td class="px-6 py-3 text-gray-600">{{ $block->slug }}</td>
                            <td class="px-6 py-3">
                                <span
                                    class="px-3 py-1 rounded text-white text-sm {{ $block->status === 'active' ? 'bg-green-500' : 'bg-red-500' }}">
                                    {{ ucfirst($block->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 flex space-x-4">
                                <a href="{{ route('admin.page-blocks.edit', $block->id) }}"
                                    class="text-blue-500 hover:text-blue-700 transition">
                                    <i class="uil uil-edit"></i>
                                </a>
                                <button type="button" onclick="openDeleteModal({{ $block->id }}, '{{ $block->title }}')"
                                    class="text-red-500 hover:text-red-700 transition">
                                    <i class="uil uil-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden mt-6 space-y-4">
            @foreach ($pageBlocks as $block)
                <div id="mobile-row-{{ $block->id }}" class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $block->title }}</h3>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.page-blocks.edit', $block->id) }}"
                                class="text-blue-500 hover:text-blue-700 transition">
                                <i class="uil uil-edit"></i>
                            </a>
                            <button type="button" onclick="openDeleteModal({{ $block->id }}, '{{ $block->title }}')"
                                class="text-red-500 hover:text-red-700 transition">
                                <i class="uil uil-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    <div class="text-sm text-gray-600 mb-2">{{ $block->slug }}</div>
                    <span
                        class="inline-block px-3 py-1 rounded text-white text-sm {{ $block->status === 'active' ? 'bg-green-500' : 'bg-red-500' }}">
                        {{ ucfirst($block->status) }}
                    </span>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $pageBlocks->links() }}
        </div>
    </div>

    <!-- SweetAlert2 Delete Confirmation & AJAX Search -->
    <script>
        function openDeleteModal(blockId, blockTitle) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to delete '" + blockTitle + "'. This cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/admin/page-blocks/" + blockId,
                        type: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Deleted!', response.message, 'success');
                                $("#row-" + blockId).fadeOut(500, function() {
                                    $(this).remove();
                                });
                                $("#mobile-row-" + blockId).fadeOut(500, function() {
                                    $(this).remove();
                                });
                            } else {
                                Swal.fire('Error!', response.message ||
                                    'Failed to delete the page block.', 'error');
                            }
                        },
                        error: function(xhr) {
                            let errorMessage = 'An error occurred while deleting.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            Swal.fire('Error!', errorMessage, 'error');
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        }

        // jQuery AJAX Search Functionality
        let searchTimer;
        $("#searchInput").on("keyup", function() {
            clearTimeout(searchTimer); // Clear any existing timer

            searchTimer = setTimeout(() => {
                let query = $(this).val();

                $.ajax({
                    url: "{{ route('admin.page-blocks.search') }}",
                    type: "GET",
                    data: {
                        q: query
                    },
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    success: function(data) {
                        // Update desktop view
                        $("#staticBlockTableBody").html(data.html);
                        // Update mobile view
                        let mobileContainer = $(".md\\:hidden.mt-6.space-y-4");
                        if (mobileContainer.length) {
                            mobileContainer.html(data.mobileHtml || '');
                        }
                    },
                    error: function(xhr) {
                        console.error("Fetch error:", xhr.responseText);
                    }
                });
            }, 500); // 500ms debounce delay
        });
    </script>
@endsection
