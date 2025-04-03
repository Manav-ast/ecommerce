@extends('admin.dashboard')

@section('content')
    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
            <!-- Page Title -->
            <h2 class="text-2xl font-bold mb-4 text-gray-800 text-center">Add New Administrator</h2>

            <!-- Form -->
            <form id="adminForm" action="{{ route('admin.admins.store') }}" method="POST" class="space-y-3">
                @csrf

                <!-- Name -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter administrator's name">
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter administrator's email">
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Phone Number</label>
                    <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number') }}"
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter phone number">
                    @error('phone_number')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter password">
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Confirm password">
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Role</label>
                    <select name="role_id" id="role_id"
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Status</label>
                    <select name="status" id="status"
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-2 mt-6">
                    <a href="{{ route('admin.admins.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">Cancel</a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">Create
                        Administrator</button>
                </div>
            </form>
        </div>
    </div>

    {{-- <!-- Include jQuery and jQuery Validation Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/additional-methods.min.js"></script> --}}

    <script>
        $(document).ready(function() {
            // Custom validation method for phone number
            $.validator.addMethod("phoneFormat", function(value, element) {
                return this.optional(element) || /^[0-9\+\-\(\)\s]+$/.test(value);
            }, "Please enter a valid phone number");

            // Initialize form validation
            $("#adminForm").validate({
                // Validation rules
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 50
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    phone_number: {
                        phoneFormat: true
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    },
                    role_id: {
                        required: true
                    },
                    status: {
                        required: true
                    }
                },
                // Validation error messages
                messages: {
                    name: {
                        required: "Please enter a name",
                        minlength: "Name must be at least 3 characters",
                        maxlength: "Name cannot be more than 50 characters"
                    },
                    email: {
                        required: "Please enter an email address",
                        email: "Please enter a valid email address"
                    },
                    phone_number: {
                        phoneFormat: "Please enter a valid phone number"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Password must be at least 8 characters"
                    },
                    password_confirmation: {
                        required: "Please confirm your password",
                        equalTo: "Passwords do not match"
                    },
                    role_id: {
                        required: "Please select a role"
                    },
                    status: {
                        required: "Please select a status"
                    }
                },
                // Error placement
                errorPlacement: function(error, element) {
                    error.addClass("text-red-500 text-sm mt-1");
                    error.insertAfter(element);
                },
                // Highlight function
                highlight: function(element) {
                    $(element).addClass("border-red-500").removeClass("focus:ring-blue-500").addClass("focus:ring-red-500");
                },
                // Unhighlight function
                unhighlight: function(element) {
                    $(element).removeClass("border-red-500").removeClass("focus:ring-red-500").addClass("focus:ring-blue-500");
                },
                // Submit handler
                submitHandler: function(form) {
                    // You can add custom submission logic here if needed
                    form.submit();
                }
            });
        });
    </script>
@endsection