@extends('admin.dashboard')

@section('content')
    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
            <!-- Page Title -->
            <h2 class="text-2xl font-bold mb-4 text-gray-800 text-center">Edit User</h2>

            <!-- Form -->
            <form id="editUserForm" action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-3">
                @csrf
                @method('PUT')

                <!-- User Name -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter user's name">
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter user's email">
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Phone Number</label>
                    <input type="text" name="phone_no" id="phone_no" value="{{ old('phone_no', $user->phone_no) }}"
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter 10-digit phone number">
                    @error('phone_no')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password (Optional) -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">New Password (Leave empty to keep current)</label>
                    <input type="password" name="password" id="password"
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter new password">
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Re-enter new password">
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Status</label>
                    <select name="status" id="status"
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active
                        </option>
                        <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive
                        </option>
                    </select>
                    @error('status')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Update User
                </button>
            </form>
        </div>
    </div>
@endsection

<!-- Include jQuery and jQuery Validation Plugin -->
@push('scripts')
    <script>
        $(document).ready(function() {
            // Form validation
            $("#editUserForm").validate({
                // Add remote validation for email and phone number
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 50
                    },
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: "/admin/users/check-email",
                            type: "post",
                            data: {
                                email: function() {
                                    return $("#email").val();
                                },
                                user_id: function() {
                                    return "{{ $user->id }}";
                                },
                                _token: "{{ csrf_token() }}"
                            }
                        }
                    },
                    phone_no: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10,
                        remote: {
                            url: "/admin/users/check-phone",
                            type: "post",
                            data: {
                                phone_no: function() {
                                    return $("#phone_no").val();
                                },
                                user_id: function() {
                                    return "{{ $user->id }}";
                                },
                                _token: "{{ csrf_token() }}"
                            }
                        }
                    },
                    password: {
                        minlength: 6
                    },
                    password_confirmation: {
                        equalTo: "#password"
                    },
                    status: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter the user's name",
                        minlength: "Name must be at least 3 characters long",
                        maxlength: "Name cannot exceed 50 characters"
                    },
                    email: {
                        required: "Please enter an email address",
                        email: "Please enter a valid email address",
                        remote: "This email is already in use"
                    },
                    phone_no: {
                        required: "Please enter a phone number",
                        digits: "Phone number must contain only digits",
                        minlength: "Phone number must be exactly 10 digits",
                        maxlength: "Phone number must be exactly 10 digits",
                        remote: "This phone number is already in use"
                    },
                    password: {
                        minlength: "Password must be at least 6 characters long"
                    },
                    password_confirmation: {
                        equalTo: "Passwords do not match"
                    },
                    status: {
                        required: "Please select a status"
                    }
                },
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
                    phone_no: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    password: {
                        minlength: 6
                    },
                    password_confirmation: {
                        equalTo: "#password"
                    },
                    status: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter the user's name",
                        minlength: "Name must be at least 3 characters long",
                        maxlength: "Name cannot exceed 50 characters"
                    },
                    email: {
                        required: "Please enter an email address",
                        email: "Please enter a valid email address"
                    },
                    phone_no: {
                        required: "Please enter a phone number",
                        digits: "Phone number must contain only digits",
                        minlength: "Phone number must be exactly 10 digits",
                        maxlength: "Phone number must be exactly 10 digits"
                    },
                    password: {
                        minlength: "Password must be at least 6 characters long"
                    },
                    password_confirmation: {
                        equalTo: "Passwords do not match"
                    },
                    status: {
                        required: "Please select a status"
                    }
                },
                errorElement: "span",
                errorClass: "text-red-500 text-sm",
                submitHandler: function(form) {
                    // Show loading state or disable button if needed
                    $("button[type='submit']").prop('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...'
                    );

                    form.submit();
                }
            });
        });
    </script>
@endpush
