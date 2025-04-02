@extends('admin.dashboard')

@section('content')
    <div class="p-10">
        <!-- Page Title -->
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Admins</h2>

        <!-- Search and Add Button -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-white p-4 rounded-lg shadow-md">
            <input type="text" id="searchInput" placeholder="Search Admins"
                class="border p-2 rounded-md w-full md:w-1/3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <a href="{{ route('admin.admins.create') }}"
                class="w-full md:w-auto bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition text-center">
                <i class="uil uil-user-plus"></i> Admin
            </a>
        </div>

        <!-- Admins Table -->
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
                    <tbody id="adminTableBody">
                        @foreach ($admins as $admin)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="px-6 py-3 text-gray-800">{{ $admin->id }}</td>
                                <td class="px-6 py-3 text-gray-800">{{ $admin->name }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $admin->email }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $admin->phone_number }}</td>
                                <td class="px-6 py-3">
                                    <span
                                        class="px-3 py-1 rounded-full text-white text-sm {{ $admin->status == 'active' ? 'bg-green-500' : 'bg-red-500' }}">
                                        {{ ucfirst($admin->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 flex space-x-4">
                                    <a href="{{ route('admin.admins.edit', $admin->id) }}"
                                        class="text-blue-500 hover:text-blue-700 transition">
                                        <i class="uil uil-edit"></i>
                                    </a>
                                    <button type="button"
                                        onclick="openDeleteModal({{ $admin->id }}, '{{ $admin->name }}')"
                                        class="text-red-500 hover:text-red-700 transition">
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
                <div id="adminTableBody" class="space-y-4 p-4">
                    @foreach ($admins as $admin)
                        <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="font-semibold text-gray-800">#{{ $admin->id }} - {{ $admin->name }}
                                    </h3>
                                    <p class="text-gray-600 text-sm">{{ $admin->email }}</p>
                                    <p class="text-gray-600 text-sm">{{ $admin->phone_no }}</p>
                                </div>
                                <span
                                    class="px-3 py-1 rounded-full text-white text-sm {{ $admin->status == 'active' ? 'bg-green-500' : 'bg-red-500' }}">
                                    {{ ucfirst($admin->status) }}
                                </span>
                            </div>
                            <div class="flex space-x-4 justify-end border-t pt-3">
                                <a href="{{ route('admin.admins.edit', $admin->id) }}"
                                    class="text-blue-500 hover:text-blue-700 transition">
                                    <i class="uil uil-edit"></i>
                                </a>
                                <button type="button"
                                    onclick="openDeleteModal({{ $admin->id }}, '{{ $admin->name }}')"
                                    class="text-red-500 hover:text-red-700 transition">
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
            {{ $admins->links() }}
        </div>
    </div>

    <!-- SweetAlert2 is loaded in the dashboard layout -->

    <!-- JavaScript for Delete Confirmation Modal & AJAX Search -->
    <script>
        function openDeleteModal(adminId, adminName) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to delete '" + adminName + "'. This cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create form element
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = "{{ url('/admin/admins') }}/" + adminId;

                    // Add CSRF token
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    // Add method field
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    form.appendChild(methodField);

                    // Append form to body and submit
                    document.body.appendChild(form);
                    form.submit();

                    // Show success message after deletion
                    Swal.fire(
                        'Deleted!',
                        adminName + ' has been deleted.',
                        'success'
                    );
                }
            });
        }

        // AJAX Search Functionality with Debounce
        let searchTimer;
        document.getElementById("searchInput").addEventListener("keyup", function() {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(() => {
                let query = this.value.trim();

                fetch("{{ route('admin.admins.search') }}?q=" + encodeURIComponent(query), {
                        method: "GET",
                        headers: {
                            "X-Requested-With": "XMLHttpRequest"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Update desktop view
                        const desktopTableBody = document.querySelector(
                            '.hidden.md\\:block #adminTableBody');
                        if (desktopTableBody) {
                            desktopTableBody.innerHTML = data.html;
                        }

                        // Update mobile view
                        const mobileTableBody = document.querySelector('.md\\:hidden #adminTableBody');
                        if (mobileTableBody) {
                            mobileTableBody.innerHTML = data.mobileHtml;
                        }
                    })
                    .catch(error => console.error("Fetch error:", error));
            }, 500);
        });
    </script>
@endsection
