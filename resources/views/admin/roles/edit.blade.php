@extends('admin.dashboard')

@section('content')
    <div class="flex justify-center items-center min-h-screen w-full">
        <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
            <!-- Page Title -->
            <h2 class="text-2xl font-bold mb-4 text-gray-800 text-center">Edit Role</h2>

            <!-- Form -->
            <form id="editRoleForm" action="{{ route('admin.roles.update', $role->id) }}" method="POST" class="space-y-3">
                @csrf
                @method('PUT')

                <!-- Role Name -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Role Name</label>
                    <input type="text" name="role_name" id="role_name" required
                        value="{{ old('role_name', $role->role_name) }}"
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter role name">
                    @error('role_name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Role Description -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Description</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter role description (optional)">{{ old('description', $role->description) }}</textarea>
                    @error('description')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Update Role
                </button>
            </form>
        </div>
    </div>
@endsection

<!-- Include jQuery and jQuery Validation Plugin -->
@push('scripts')
    <script>
        $(document).ready(function() {
            $("#editRoleForm").validate({
                rules: {
                    role_name: {
                        required: true,
                        minlength: 3,
                        maxlength: 50
                    },
                    description: {
                        maxlength: 255
                    }
                },
                messages: {
                    role_name: {
                        required: "Please enter a role name",
                        minlength: "Role name must be at least 3 characters long",
                        maxlength: "Role name cannot exceed 50 characters"
                    },
                    description: {
                        maxlength: "Description cannot exceed 255 characters"
                    }
                },
                errorElement: "span",
                errorClass: "text-red-500 text-sm"
            });
        });
    </script>
@endpush
