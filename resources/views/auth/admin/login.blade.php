<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login - E-Commerce</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen"> <!-- Centered Layout -->

    <div class="w-full max-w-md bg-white shadow-lg border-t-4 border-blue-500 px-8 py-6 rounded-lg">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('assets/images/logo.svg') }}" alt="Company Logo" class="w-24 h-24">
        </div>

        <h2 class="text-2xl font-semibold text-gray-800 text-center">User Login</h2>
        <p class="text-gray-500 text-sm text-center mb-4">Sign in to your account</p>

        <form method="POST" action="{{ route('admin.authenticate') }}" class="space-y-4" autocomplete="off">
            @csrf
            <div>
                <input type="email" name="email" placeholder="Email" value="admin@gmail.com"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500" 
                    required>
            </div>

            <div>
                <input type="password" name="password" placeholder="Password" value="Admin@1234"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500" 
                    required>
            </div>

            {{-- <div class="flex justify-between items-center text-sm">
                <label class="flex items-center text-gray-600">
                    <input type="checkbox" class="mr-2"> Remember me
                </label>
                <a href="#" class="text-blue-500 hover:underline">Forgot password?</a>
            </div> --}}

            <button type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded-lg transition-all">
                Login
            </button>
        </form>
    </div>

</body>

</html>
