<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - E-Commerce</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen"> <!-- Centered Layout -->

    <div class="w-full max-w-md bg-white shadow-lg border-t-4 border-blue-500 px-8 py-6 rounded-lg">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('assets/images/logo.svg') }}" alt="Company Logo" class="w-24 h-24">
        </div>

        <h2 class="text-2xl font-semibold text-gray-800 text-center">Admin Login</h2>
        <p class="text-gray-500 text-sm text-center mb-4">Sign in to your account</p>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4 rounded">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <ul class="text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

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
