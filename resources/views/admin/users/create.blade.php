@extends('admin.dashboard')

@section('content')
<div class="flex justify-center items-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
        <!-- Page Title -->
        <h2 class="text-2xl font-bold mb-4 text-gray-800 text-center">Add New User</h2>

        <!-- Form -->
        <form id="addUserForm" action="{{ route('admin.users.store') }}" method="POST" class="space-y-3">
            @csrf

            <!-- User Name -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Name</label>
                <input type="text" name="name" required value="{{ old('name') }}"
                    class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter user's name">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email" name="email" required value="{{ old('email') }}"
                    class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter user's email">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Phone Number -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Phone Number</label>
                <input type="text" name="phone_no" required value="{{ old('phone_no') }}"
                    class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter 10-digit phone number">
                @error('phone_no') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter password">
                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Re-enter password">
            </div>

            <!-- Status -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Status</label>
                <select name="status" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                Add User
            </button>
        </form>
    </div>
</div>
@endsection
