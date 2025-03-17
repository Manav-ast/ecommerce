@extends('admin.dashboard')

@section('content')
<div class="p-10">
    <!-- Page Title -->
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Users</h2>

    <!-- Search and Add Button -->
    <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-md">
        <input type="text" id="searchInput" placeholder="Search Users"
            class="border p-2 rounded-md w-1/3 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <a href="{{ route('admin.users.create') }}"
            class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
            <i class="uil uil-plus"></i> User
        </a>
    </div>

    <!-- Users Table -->
    <div class="mt-6 bg-white shadow-md rounded-lg overflow-hidden">
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
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                        <td class="px-6 py-3 text-gray-800">{{ $user->id }}</td>
                        <td class="px-6 py-3 text-gray-800">{{ $user->name }}</td>
                        <td class="px-6 py-3 text-gray-600">{{ $user->email }}</td>
                        <td class="px-6 py-3 text-gray-600">{{ $user->phone_no }}</td>
                        <td class="px-6 py-3">
                            <span class="px-3 py-1 rounded-full text-white text-sm 
                                {{ $user->status == 'active' ? 'bg-green-500' : 'bg-red-500' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-3 flex space-x-4">
                            <!-- Edit Button -->
                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                class="text-blue-500 hover:text-blue-700 transition">
                                <i class="uil uil-edit"></i>
                            </a>

                            <!-- Delete Button (Triggers Modal) -->
                            <button type="button" onclick="openDeleteModal({{ $user->id }}, '{{ $user->name }}')"
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
    function openDeleteModal(userId, userName) {
        document.getElementById("deleteForm").action = "{{ url('/admin/users') }}/" + userId;
        document.getElementById("deleteMessage").textContent = "Are you sure you want to delete '" + userName + "'?";
        document.getElementById("deleteModal").classList.remove("hidden");
    }

    function closeDeleteModal() {
        document.getElementById("deleteModal").classList.add("hidden");
    }

    // AJAX Search Functionality
    document.getElementById("searchInput").addEventListener("keyup", function() {
        let query = this.value.trim(); // Remove leading/trailing spaces

        fetch("{{ route('admin.users.search') }}?q=" + encodeURIComponent(query), {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest" // Ensure Laravel detects AJAX
            }
        })
        .then(response => response.json()) // Expect JSON response
        .then(data => {
            document.getElementById("userTableBody").innerHTML = data.html; // Inject new table content
        })
        .catch(error => console.error("Fetch error:", error));
    });
</script>
@endsection
