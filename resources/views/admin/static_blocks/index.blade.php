@extends('admin.dashboard')

@section('content')
    <div class="p-10">
        <!-- Page Title -->
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Static Blocks</h2>

        <!-- Search and Add Button -->
        <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-md">
            <input type="text" id="searchInput" placeholder="Search Static Blocks"
                class="border p-2 rounded-md w-1/3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <a href="{{ route('admin.static_blocks.create') }}"
                class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                <i class="uil uil-plus"></i> Static Block
            </a>
        </div>

        <!-- Static Blocks Table -->
        <div class="mt-6 bg-white shadow-md rounded-lg overflow-hidden">
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
                    @foreach ($staticBlocks as $block)
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
                                <a href="{{ route('admin.static_blocks.edit', $block->id) }}"
                                    class="text-blue-500 hover:text-blue-700 transition">
                                    <i class="uil uil-edit"></i>
                                </a>

                                <!-- Delete Button (Triggers Modal) -->
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
        <!-- Pagination -->
        <div class="mt-6">
            {{ $staticBlocks->links() }}
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
                        url: "{{ route('admin.static_blocks.destroy', $block->id) }}",
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire('Deleted!', response.message, 'success');

                            // Remove the deleted row from the table
                            $("#row-" + blockId).fadeOut(500, function() {
                                $(this).remove();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', 'An error occurred while deleting.', 'error');
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        }


        // AJAX Search Functionality
        document.getElementById("searchInput").addEventListener("keyup", function() {
            let query = this.value;

            fetch("{{ route('admin.static_blocks.search') }}?q=" + encodeURIComponent(query), {
                    method: "GET",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("staticBlockTableBody").innerHTML = data.html;
                })
                .catch(error => console.error("Fetch error:", error));
        });
    </script>
@endsection
