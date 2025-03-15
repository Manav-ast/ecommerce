<nav class="bg-white shadow-md">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="text-2xl font-bold text-gray-800">
            FashionStore
        </a>

        <!-- Navigation Links -->
        <div class="hidden md:flex space-x-6">
            <a href="{{ url('/') }}" class="text-gray-700 hover:text-gray-900">Home</a>
            <a href="{{ url('/shop') }}" class="text-gray-700 hover:text-gray-900">Shop</a>
            <a href="{{ url('/about') }}" class="text-gray-700 hover:text-gray-900">About</a>
            <a href="{{ url('/contact') }}" class="text-gray-700 hover:text-gray-900">Contact</a>
        </div>

        <!-- Cart & Auth Links -->
        <div class="flex items-center space-x-4">
            <a href="{{ url('/cart') }}" class="text-gray-700 hover:text-gray-900">
                🛒 ({{ session('cart_count', 0) }})
            </a>
            @auth
                <a href="{{ route('homepage') }}" class="text-gray-700 hover:text-gray-900">Dashboard</a>
                <form action="{{ route('user.logout') }}" method="GET" class="inline">
                    @csrf

                    <button type="submit" class="text-gray-700 hover:text-gray-900">Logout</button>
                </form>
            @else
                <a href="{{ route('user.login') }}" class="text-gray-700 hover:text-gray-900">Login</a>
                <a href="{{ route('user.register') }}" class="text-gray-700 hover:text-gray-900">Register</a>
            @endauth
        </div>

        <!-- Mobile Menu Button -->
        <button class="md:hidden text-gray-700 focus:outline-none">
            ☰
        </button>
    </div>
</nav>