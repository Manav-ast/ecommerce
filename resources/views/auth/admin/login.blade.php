<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="w-full max-w-md p-8 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">Admin Login</h2>
        
        <form method="POST" action="{{ route('admin.authenticate') }}" class="space-y-4">
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

            <button type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded-lg transition-all">
                Login
            </button>
        </form>

        <p class="text-center text-gray-600 text-sm mt-4">
            Forgot password? <a href="#" class="text-blue-500 hover:underline">Reset here</a>
        </p>
    </div>

</body>
</html>
