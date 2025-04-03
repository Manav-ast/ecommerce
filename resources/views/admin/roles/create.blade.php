@extends('admin.dashboard')

@section('content')
    <div class="p-4 md:p-10">
        <!-- Page Title -->
        <h2 class="text-2xl md:text-3xl font-bold mb-4 md:mb-6 text-gray-800">Create Role</h2>

        <form id="roleForm" action="{{ route('admin.roles.store') }}" method="POST" class="max-w-2xl mx-auto">
            @csrf
            <div class="bg-white rounded-lg shadow-md p-6">
                <!-- Role Name Input -->
                <div class="mb-6">
                    <label for="name" class="block text-lg font-medium text-gray-700 mb-2">Role Name</label>
                    <input type="text" name="name" id="name"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Is Super Admin Toggle -->
                <div class="mb-6">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_super_admin" class="form-checkbox h-5 w-5 text-blue-600 rounded"
                            {{ old('is_super_admin') ? 'checked' : '' }}>
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
                                    {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
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
                    Save Role
                </button>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $("#roleForm").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    "permissions[]": {
                        required: true,
                    }
                },
                messages: {
                    name: {
                        required: "Role name is required.",
                        minlength: "Role name must be at least 3 characters long."
                    },
                    "permissions[]": {
                        required: "Please select at least one permission."
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    error.addClass("mt-1 text-sm text-red-500");
                    element.closest("div").append(error);
                },
                highlight: function(element) {
                    $(element).addClass("border-red-500").removeClass("border-gray-300");
                },
                unhighlight: function(element) {
                    $(element).removeClass("border-red-500").addClass("border-gray-300");
                }
            });
        });
    </script>
@endpush
