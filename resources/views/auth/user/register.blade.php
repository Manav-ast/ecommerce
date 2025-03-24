{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <div class="max-w-md mx-auto bg-white p-8 mt-10 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center text-gray-800">Register</h2>

        <form method="POST" action="{{ route('user.register') }}">
            @csrf

            <!-- Name -->
            <div class="mt-4">
                <label for="name" class="block text-sm font-medium text-gray-600">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" 
                    class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('name') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Email -->
            <div class="mt-4">
                <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" 
                    class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('email') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
                <input type="password" id="password" name="password" 
                    class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('password') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-600">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" 
                    class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Contact Number -->
            <div class="mt-4">
                <label for="phone_no" class="block text-sm font-medium text-gray-600">Phone Number</label>
                <input type="text" id="phone_no" name="phone_no" value="{{ old('phone_no') }}"
                    class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('phone_no') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit"
                    class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Register
                </button>
            </div>
        </form>

        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">Already have an account? <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700">Login</a></p>
        </div>
    </div>

</body>
</html> --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - E-Commerce</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen"> <!-- Centering the form -->

    <div class="w-full max-w-md bg-white shadow-md border-t-4 border-blue-500 px-6 py-4 rounded-lg">
        <!-- Company Logo (Optimized Size) -->
        <div class="flex justify-center mb-4">
            <img src="{{ asset('assets/images/logo.svg') }}" alt="Company Logo" class="w-20 h-20">
        </div>

        <h2 class="text-lg uppercase font-semibold text-gray-700 text-center">Create an Account</h2>
        <p class="text-gray-500 text-xs text-center mb-2">Register as a new customer</p>

        <form method="POST" action="{{ route('user.register') }}">
            @csrf
            <div class="space-y-2">
                <div>
                    <label for="name" class="text-gray-600 block mb-1 text-sm">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="w-full border border-gray-300 px-3 py-2 rounded-md text-gray-700 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400"
                        placeholder="John Doe">
                    @error('name')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="email" class="text-gray-600 block mb-1 text-sm">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="w-full border border-gray-300 px-3 py-2 rounded-md text-gray-700 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400"
                        placeholder="youremail@domain.com">
                    @error('email')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="phone_no" class="text-gray-600 block mb-1 text-sm">Phone Number</label>
                    <input type="text" name="phone_no" id="phone_no" value="{{ old('phone_no') }}"
                        class="w-full border border-gray-300 px-3 py-2 rounded-md text-gray-700 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400"
                        placeholder="Enter your phone number">
                    @error('phone_no')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="password" class="text-gray-600 block mb-1 text-sm">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full border border-gray-300 px-3 py-2 rounded-md text-gray-700 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400"
                        placeholder="Enter your password">
                    @error('password')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="text-gray-600 block mb-1 text-sm">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full border border-gray-300 px-3 py-2 rounded-md text-gray-700 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400"
                        placeholder="Re-enter password">
                </div>
            </div>

            <div class="mt-2">
                <button type="submit"
                    class="w-full py-2 text-center text-white bg-blue-500 border border-blue-500 rounded-md hover:bg-blue-600 transition font-medium shadow-sm">
                    Create Account
                </button>
            </div>
        </form>

        <p class="mt-2 text-center text-gray-600 text-sm">Already have an account?
            <a href="{{ route('user.login') }}" class="text-blue-500 font-medium hover:underline">Login now</a>
        </p>
    </div>

    <script>
        $(document).ready(function() {
            // Add custom validation methods for email and phone number duplication check
            $.validator.addMethod('emailNotExists', function(value, element) {
                let isValid = true;
                $.ajax({
                    url: '/check-email',
                    type: 'POST',
                    data: {
                        email: value,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    async: false,
                    success: function(response) {
                        isValid = response.available;
                    }
                });
                return isValid;
            }, 'This email is already registered');

            $.validator.addMethod('phoneNotExists', function(value, element) {
                let isValid = true;
                $.ajax({
                    url: '/check-phone',
                    type: 'POST',
                    data: {
                        phone_no: value,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    async: false,
                    success: function(response) {
                        isValid = response.available;
                    }
                });
                return isValid;
            }, 'This phone number is already registered');

            $('form').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 50
                    },
                    email: {
                        required: true,
                        email: true,
                        emailNotExists: true
                    },
                    phone_no: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10,
                        phoneNotExists: true
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name",
                        minlength: "Name must be at least 3 characters long",
                        maxlength: "Name cannot exceed 50 characters"
                    },
                    email: {
                        required: "Please enter your email address",
                        email: "Please enter a valid email address"
                    },
                    phone_no: {
                        required: "Please enter your phone number",
                        digits: "Please enter only digits",
                        minlength: "Phone number must be 10 digits",
                        maxlength: "Phone number must be 10 digits"
                    },
                    password: {
                        required: "Please enter a password",
                        minlength: "Password must be at least 6 characters long"
                    },
                    password_confirmation: {
                        required: "Please confirm your password",
                        equalTo: "Passwords do not match"
                    }
                },
                errorClass: 'text-red-500 text-xs',
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                }
            });
        });
    </script>
</body>

</html>
