<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - E-Commerce</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

</body>

</html>
