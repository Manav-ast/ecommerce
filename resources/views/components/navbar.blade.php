<nav class="bg-white shadow-md relative">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="text-2xl font-bold text-gray-800">
            FashionStore
        </a>

        <!-- Navigation Links - Desktop -->
        <div class="hidden md:flex space-x-6" id="desktop-menu">
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
                <div class="flex items-center">
                    <!-- Username display -->
                    <span class="text-gray-700 font-medium mr-4 hidden md:inline">{{ Auth::user()->name }}</span>
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-gray-900">Dashboard</a>
                    <form action="{{ route('user.logout') }}" method="GET" class="inline ml-4">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-gray-900">Logout</button>
                    </form>
                </div>
            @else
                <a href="{{ route('user.login') }}" class="text-gray-700 hover:text-gray-900">Login</a>
                <a href="{{ route('user.register') }}" class="text-gray-700 hover:text-gray-900">Register</a>
            @endauth
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobile-menu-button" class="md:hidden text-gray-700 focus:outline-none">
            ☰
        </button>
    </div>

    <!-- Mobile Navigation Menu -->
    <div id="mobile-menu" class="hidden md:hidden w-full bg-white shadow-md absolute z-20">
        <div class="container mx-auto px-6 py-3 flex flex-col space-y-3">
            <a href="{{ url('/') }}"
                class="text-gray-700 hover:text-gray-900 py-2 border-b border-gray-100">Home</a>
            <a href="{{ url('/shop') }}"
                class="text-gray-700 hover:text-gray-900 py-2 border-b border-gray-100">Shop</a>
            <a href="{{ url('/about') }}"
                class="text-gray-700 hover:text-gray-900 py-2 border-b border-gray-100">About</a>
            <a href="{{ url('/contact') }}" class="text-gray-700 hover:text-gray-900 py-2">Contact</a>
        </div>
    </div>
</nav>

<!-- Include navbar JavaScript -->
<script src="{{ asset('js/navbar.js') }}"></script>
