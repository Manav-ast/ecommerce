@extends('admin.dashboard')

@section('content')
<div class="p-10">
    <!-- Page Title -->
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Roles</h2>

    <!-- Search and Add Button -->
    <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-md">
        <input type="text" id="searchInput" placeholder="Search Roles"
            class="border p-2 rounded-md w-1/3 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <a href="{{ route('admin.roles.create') }}"
            class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
            <i class="uil uil-plus"></i> Add Role
        </a>
    </div>

    <!-- Roles Table -->
    <div class="mt-6 bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-100 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-gray-600">ID</th>
                    <th class="px-6 py-3 text-left text-gray-600">Role Name</th>
                    <th class="px-6 py-3 text-left text-gray-600">Description</th>
                    <th class="px-6 py-3 text-left text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody id="roleTableBody">
                @foreach ($roles as $role)
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                        <td class="px-6 py-3 text-gray-800">{{ $role->id }}</td>
                        <td class="px-6 py-3 text-gray-800">{{ $role->role_name }}</td>
                        <td class="px-6 py-3 text-gray-600">{{ $role->description ?? 'No description' }}</td>
                        <td class="px-6 py-3 flex space-x-4">
                            <!-- Edit Button -->
                            <a href="{{ route('admin.roles.edit', $role->id) }}"
                                class="text-blue-500 hover:text-blue-700 transition">
                                <i class="uil uil-edit"></i>
                            </a>

                            <!-- Delete Button (Triggers Modal) -->
                            <button type="button" onclick="openDeleteModal({{ $role->id }}, '{{ $role->role_name }}')"
                                class="text-red-500 hover:text-red-700 transition">
                                <i class="uil uil-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 flex items-center justify-center hidden bg-gray-900 bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-xl font-semibold text-gray-800">Confirm Deletion</h2>
        <p class="text-gray-600 mt-2" id="deleteMessage"></p>

        <!-- Form -->
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="mt-4 flex justify-end space-x-2">
                <button type="button" onclick="closeDeleteModal()"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                    Cancel
                </button>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript for Delete Confirmation Modal & AJAX Search -->
<script>
    function openDeleteModal(roleId, roleName) {
        document.getElementById("deleteForm").action = "{{ url('/admin/roles') }}/" + roleId;
        document.getElementById("deleteMessage").textContent = "Are you sure you want to delete '" + roleName + "'?";
        document.getElementById("deleteModal").classList.remove("hidden");
    }

    function closeDeleteModal() {
        document.getElementById("deleteModal").classList.add("hidden");
    }

    // AJAX Search Functionality
    document.getElementById("searchInput").addEventListener("keyup", function() {
        let query = this.value.trim(); // Remove leading/trailing spaces

        fetch("{{ route('admin.roles.search') }}?q=" + encodeURIComponent(query), {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest" // Ensure Laravel detects AJAX
            }
        })
        .then(response => response.json()) // Expect JSON response
        .then(data => {
            document.getElementById("roleTableBody").innerHTML = data.html; // Inject new table content
        })
        .catch(error => console.error("Fetch error:", error));
    });
</script>
@endsection
