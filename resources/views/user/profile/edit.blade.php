@extends('layouts.users.app')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="flex flex-wrap -mx-4">
            <!-- Sidebar -->
            <div class="w-full md:w-1/4 px-4 mb-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex flex-col items-center text-center mb-6">
                        <div
                            class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 text-3xl mb-3">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h2>
                        <p class="text-gray-600 text-sm">{{ $user->email }}</p>
                    </div>

                    <hr class="my-4">

                    {{-- <nav class="space-y-2">
                        <a href="{{ route('profile.dashboard') }}"
                            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-700 transition">
                            <i class="fa-solid fa-tachometer-alt w-5 h-5"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('profile.orders') }}"
                            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-700 transition">
                            <i class="fa-solid fa-shopping-bag w-5 h-5"></i>
                            <span>My Orders</span>
                        </a>
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center space-x-2 p-2 rounded-lg bg-blue-50 text-blue-700">
                            <i class="fa-solid fa-user-edit w-5 h-5"></i>
                            <span>Account Details</span>
                        </a>
                        <a href="{{ route('profile.addresses') }}"
                            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-700 transition">
                            <i class="fa-solid fa-map-marker-alt w-5 h-5"></i>
                            <span>Addresses</span>
                        </a>
                        <form method="GET" action="{{ route('user.logout') }}" class="mt-4">
                            @csrf
                            <button type="submit"
                                class="flex items-center space-x-2 p-2 rounded-lg hover:bg-red-50 text-gray-700 hover:text-red-700 transition w-full">
                                <i class="fa-solid fa-sign-out-alt w-5 h-5"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </nav> --}}

                    <x-users.profile-navbar />
                </div>
            </div>

            <!-- Main Content -->
            <div class="w-full md:w-3/4 px-4">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Account Details</h1>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" id="editProfileForm">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="phone_no" class="block text-gray-700 text-sm font-bold mb-2">Phone Number</label>
                            <input type="text" name="phone_no" id="phone_no"
                                value="{{ old('phone_no', $user->phone_no) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('phone_no') border-red-500 @enderror">
                            @error('phone_no')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="current_password" class="block text-gray-700 text-sm font-bold mb-2">Current
                                Password (required to save changes)</label>
                            <input type="password" name="current_password" id="current_password"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('current_password') border-red-500 @enderror">
                            @error('current_password')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">New Password (leave
                                blank to keep current)</label>
                            <input type="password" name="password" id="password"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror">
                            @error('password')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirm
                                New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition">
                                Update Profile
                            </button>
                            <a href="{{ route('profile.dashboard') }}"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Form validation
            $("#editProfileForm").validate({
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
                    current_password: {
                        required: true
                    },
                    password_confirmation: {
                        equalTo: "#password"
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name",
                        minlength: "Name must be at least 3 characters",
                        maxlength: "Name cannot be more than 50 characters"
                    },
                    email: {
                        required: "Please enter your email",
                        email: "Please enter a valid email address"
                    },
                    phone_no: {
                        required: "Please enter your phone number",
                        digits: "Please enter only digits",
                        minlength: "Phone number must be 10 digits",
                        maxlength: "Phone number must be 10 digits"
                    },
                    current_password: {
                        required: "Please enter your current password to save changes"
                    },
                    password_confirmation: {
                        equalTo: "Passwords do not match"
                    }
                },
                errorElement: 'p',
                errorClass: 'text-red-500 text-xs italic mt-1'
            });
        });
    </script>
@endpush
