<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Commerce</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen"> <!-- Centered Layout -->

    <div class="w-full max-w-md bg-white shadow-md border-t-4 border-blue-500 px-6 py-6 rounded-lg">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('assets/images/logo.svg') }}" alt="Company Logo" class="w-24 h-24">
        </div>

        <h2 class="text-xl uppercase font-semibold text-gray-700 text-center">Login</h2>
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

        <form method="post" action="{{ route('user.authenticate') }}" autocomplete="off">
            @csrf
            <div class="space-y-3">
                <div>
                    <label for="email" class="text-gray-600 block mb-1">Email Address</label>
                    <input type="email" name="email" id="email"
                        class="w-full border border-gray-300 px-3 py-2.5 rounded-md text-gray-700 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400"
                        placeholder="youremail@domain.com" value="manav@gmail.com">
                </div>
                <div>
                    <label for="password" class="text-gray-600 block mb-1">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full border border-gray-300 px-3 py-2.5 rounded-md text-gray-700 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400"
                        placeholder="*******" value="Test@1234">
                </div>

                <div class="flex justify-between items-center text-sm mt-1">
                    <label class="flex items-center text-gray-600">
                        <input type="checkbox" class="mr-2"> Remember me
                    </label>
                    <a href="#" class="text-blue-500 hover:underline">Forgot password?</a>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit"
                    class="w-full py-2.5 text-center text-white bg-blue-500 border border-blue-500 rounded-md hover:bg-blue-600 transition font-medium shadow-sm">
                    Login
                </button>
            </div>
        </form>

        <p class="mt-4 text-center text-gray-600 text-sm">Don't have an account?
            <a href="{{ route('user.register') }}" class="text-blue-500 font-medium hover:underline">Register now</a>
        </p>
    </div>

</body>

</html>
