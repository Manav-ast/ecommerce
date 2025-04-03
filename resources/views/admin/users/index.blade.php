@extends('admin.dashboard')

@section('content')
    <div class="p-10">
        <!-- Page Title -->
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Users</h2>

        <!-- Search and Add Button -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-white p-4 rounded-lg shadow-md">
            <input type="text" id="searchInput" placeholder="Search Users"
                class="border p-2 rounded-md w-full md:w-1/3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <a href="{{ route('admin.users.create') }}"
                class="w-full md:w-auto bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition text-center">
                <i class="uil uil-user-plus"></i> User
            </a>
        </div>

        <!-- Users Table -->
        <div class="mt-6 bg-white shadow-md rounded-lg overflow-auto">
            <div class="hidden md:block">
                <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-gray-600">ID</th>
                            <th class="px-6 py-3 text-left text-gray-600">Name</th>
                            <th class="px-6 py-3 text-left text-gray-600">Email</th>
                            <th class="px-6 py-3 text-left text-gray-600">Phone</th>
                            <th class="px-6 py-3 text-left text-gray-600">Status</th>
                            <th class="px-6 py-3 text-left text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        @foreach ($users as $user)
                            <tr id="row-{{ $user->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="px-6 py-3 text-gray-800">{{ $user->id }}</td>
                                <td class="px-6 py-3 text-gray-800">{{ $user->name }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $user->email }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $user->phone_no }}</td>
                                <td class="px-6 py-3">
                                    <span
                                        class="px-3 py-1 rounded-full text-white text-sm {{ $user->status == 'active' ? 'bg-green-500' : 'bg-red-500' }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 flex space-x-4">
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="text-blue-500 hover:text-blue-700 transition">
                                        <i class="uil uil-edit"></i>
                                    </a>
                                    <button type="button" class="text-red-500 hover:text-red-700 transition delete-btn"
                                        data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                        <i class="uil uil-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile View -->
            <div class="md:hidden">
                <div id="mobileUserTableBody" class="space-y-4 p-4">
                    @foreach ($users as $user)
                        <div id="mobile-row-{{ $user->id }}"
                            class="bg-white rounded-lg shadow p-4 border border-gray-200">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="font-semibold text-gray-800">#{{ $user->id }} - {{ $user->name }}
                                    </h3>
                                    <p class="text-gray-600 text-sm">{{ $user->email }}</p>
                                    <p class="text-gray-600 text-sm">{{ $user->phone_no }}</p>
                                </div>
                                <span
                                    class="px-3 py-1 rounded-full text-white text-sm {{ $user->status == 'active' ? 'bg-green-500' : 'bg-red-500' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </div>
                            <div class="flex space-x-4 justify-end border-t pt-3">
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                    class="text-blue-500 hover:text-blue-700 transition">
                                    <i class="uil uil-edit"></i>
                                </a>
                                <button type="button" class="text-red-500 hover:text-red-700 transition delete-btn"
                                    data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                    <i class="uil uil-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Pagination -->
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            // Delete user confirmation
            $(".delete-btn").click(function() {
                let userId = $(this).data("id");
                let userName = $(this).data("name");

                Swal.fire({
                    title: "Are you sure?",
                    text: "You are about to delete '" + userName + "'. This cannot be undone!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('/admin/users') }}/" + userId,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                _method: "DELETE"
                            },
                            success: function(response) {
                                Swal.fire("Deleted!", response.message, "success");

                                // Remove user from both desktop and mobile views
                                $("#row-" + userId).fadeOut(500, function() {
                                    $(this).remove();
                                });
                                $("#mobile-row-" + userId).fadeOut(500, function() {
                                    $(this).remove();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire("Error!", "An error occurred while deleting.",
                                    "error");
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });

            // AJAX Search with Debounce
            let searchTimer;
            $("#searchInput").on("keyup", function() {
                clearTimeout(searchTimer);

                searchTimer = setTimeout(() => {
                    let query = $(this).val().trim();

                    $.ajax({
                        url: "{{ route('admin.users.search') }}",
                        type: "GET",
                        data: {
                            q: query
                        },
                        success: function(data) {
                            // Update desktop table
                            $("#userTableBody").html(data.html);

                            // Update mobile view
                            $("#mobileUserTableBody").html(data.mobileHtml);
                        },
                        error: function(xhr) {
                            console.error("Search error:", xhr.responseText);
                        }
                    });
                }, 500); // 500ms debounce delay
            });
        });
    </script>
@endpush
