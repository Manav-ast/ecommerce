@extends('admin.dashboard')

@section('content')
    <div class="p-4 md:p-10">
        <!-- Page Title -->
        <h2 class="text-2xl md:text-3xl font-bold mb-4 md:mb-6 text-gray-800">Roles</h2>

        <!-- Search and Add Button -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-white p-4 rounded-lg shadow-md">
            <input type="text" id="searchInput" placeholder="Search Roles"
                class="border p-2 rounded-md w-full md:w-1/3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <a href="{{ route('admin.roles.create') }}"
                class="w-full md:w-auto bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition text-center">
                <i class="uil uil-plus"></i> Add Role
            </a>
        </div>

        <!-- Roles Table (Desktop) -->
        <div class="hidden md:block mt-6 bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-gray-600">ID</th>
                        <th class="px-6 py-3 text-left text-gray-600">Name</th>
                        <th class="px-6 py-3 text-left text-gray-600">Super Admin</th>
                        <th class="px-6 py-3 text-left text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody id="roleTableBody">
                    @foreach ($roles as $role)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                            <td class="px-6 py-3 text-gray-800">{{ $role->id }}</td>
                            <td class="px-6 py-3 text-gray-800">{{ $role->name }}</td>
                            <td class="px-6 py-3 text-gray-600">{{ $role->is_super_admin === 'yes' ? 'Yes' : 'No' }}</td>
                            <td class="px-6 py-3 flex space-x-4">
                                <!-- Edit Button -->
                                <a href="{{ route('admin.roles.edit', $role->id) }}"
                                    class="text-blue-500 hover:text-blue-700 transition">
                                    <i class="uil uil-edit"></i>
                                </a>

                                <!-- Delete Button (Triggers Modal) -->
                                <button type="button"
                                    onclick="openDeleteModal({{ $role->id }}, '{{ $role->role_name }}')"
                                    class="text-red-500 hover:text-red-700 transition">
                                    <i class="uil uil-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Roles Cards (Mobile) -->
        <div class="md:hidden mt-6 space-y-4" id="roleMobileCards">
            @foreach ($roles as $role)
                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="font-semibold text-gray-800">#{{ $role->id }} - {{ $role->name }}</h3>
                            <p class="text-sm text-gray-600 mt-1">Super Admin:
                                {{ $role->is_super_admin === 'yes' ? 'Yes' : 'No' }}</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.roles.edit', $role->id) }}"
                                class="text-blue-500 hover:text-blue-700 transition">
                                <i class="uil uil-edit"></i>
                            </a>
                            <button type="button"
                                onclick="openDeleteModal({{ $role->id }}, '{{ $role->role_name }}')"
                                class="text-red-500 hover:text-red-700 transition">
                                <i class="uil uil-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $roles->links() }}
        </div>
    </div>

    <!-- JavaScript for SweetAlert2 Delete Confirmation & AJAX Search -->
    <script>
        function openDeleteModal(roleId, roleName) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to delete '" + roleName + "'. This cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = $('<form>', {
                        method: 'POST',
                        action: "{{ url('/admin/roles') }}/" + roleId
                    });

                    form.append($('<input>', {
                        type: 'hidden',
                        name: '_token',
                        value: '{{ csrf_token() }}'
                    }));

                    form.append($('<input>', {
                        type: 'hidden',
                        name: '_method',
                        value: 'DELETE'
                    }));

                    $('body').append(form);
                    form.submit();

                    Swal.fire(
                        'Deleted!',
                        roleName + ' has been deleted.',
                        'success'
                    );
                }
            });
        }

        // AJAX Search Functionality
        let searchTimer;
        $("#searchInput").on("keyup", function() {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(() => {
                let query = $(this).val().trim();

                $.ajax({
                    url: "{{ route('admin.roles.search') }}",
                    method: "GET",
                    data: {
                        q: query
                    },
                    dataType: "json",
                    success: function(data) {
                        $("#roleTableBody").html(data.html);
                        $("#roleMobileCards").html(data.mobileHtml);
                    },
                    error: function(error) {
                        console.error("AJAX Error:", error);
                    }
                });
            }, 500);
        });
    </script>
@endsection
