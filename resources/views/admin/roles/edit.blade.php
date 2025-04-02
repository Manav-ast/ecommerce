@extends('admin.dashboard')

@section('content')
    <div class="p-4 md:p-10">
        <!-- Page Title -->
        <h2 class="text-2xl md:text-3xl font-bold mb-4 md:mb-6 text-gray-800">Edit Role</h2>

        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" class="max-w-2xl mx-auto">
            @csrf
            @method('PUT')
            <div class="bg-white rounded-lg shadow-md p-6">
                <!-- Role Name Input -->
                <div class="mb-6">
                    <label for="name" class="block text-lg font-medium text-gray-700 mb-2">Role Name</label>
                    <input type="text" name="name" id="name"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                        value="{{ old('name', $role->name) }}" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Is Super Admin Toggle -->
                <div class="mb-6">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_super_admin" class="form-checkbox h-5 w-5 text-blue-600 rounded"
                            {{ old('is_super_admin', $role->is_super_admin) == 'yes' ? 'checked' : '' }}>
                        <span class="ml-2 text-lg text-gray-700">Is Super Admin</span>
                    </label>
                </div>

                <!-- Permissions Section -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-700 mb-4">Permissions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($permissions as $permission)
                            <label
                                class="inline-flex items-center hover:bg-gray-50 p-2 rounded-lg transition-colors duration-150">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                    class="form-checkbox h-5 w-5 text-blue-600 rounded transition duration-150"
                                    {{ in_array($permission->id, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                                <div class="ml-2">
                                    <span
                                        class="text-gray-700 font-medium">{{ ucwords(str_replace('_', ' ', $permission->name)) }}</span>
                                    @if ($permission->description)
                                        <p class="text-gray-500 text-sm">{{ $permission->description }}</p>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 text-lg font-medium">
                    Update Role
                </button>
            </div>
        </form>
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
