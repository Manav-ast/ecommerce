<nav class="bg-blue-500 z-20">
    <div class="container flex items-center">
        <!-- Categories Dropdown (Hidden on small screens) -->
        <!-- Categories Dropdown (Hidden on small screens) -->
        <div class="px-8 py-4 bg-blue-900 items-center cursor-pointer relative group hidden md:block">
            <span class="text-white">
                <i class="fa-solid fa-bars"></i>
            </span>
            <span class="capitalize ml-2 text-white">All Categories</span>

            <!-- Dropdown -->
            <div
                class=" absolute w-full left-0 top-full bg-white shadow-md py-3 divide-y divide-gray-300 divide-dashed opacity-0 group-hover:opacity-100 transition duration-300 invisible group-hover:visible z-20">
                @foreach ($categories as $category)
                    <a href="{{ url('/shop?category=' . $category->slug) }}"
                        class="flex items-center px-6 py-3 hover:bg-blue-100 transition">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                            class="w-5 h-5 object-contain">
                        <span class="ml-6 text-gray-700 text-sm">{{ $category->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>


        <!-- Main Navigation Links -->
        <div class="flex items-center justify-between flex-grow md:pl-12 py-5">
            <div class="flex items-center space-x-6 capitalize">
                <a href="/" class="text-white hover:text-blue-200 transition">Home</a>
                <a href="{{ route('shop.index') }}" class="text-white hover:text-blue-200 transition">Shop</a>
                <a href="/contact" class="text-white hover:text-blue-200 transition">Contact Us</a>
            </div>

            <!-- Authentication -->
            @guest
                <a href="/login" class="text-white hover:text-blue-200 transition">Login</a>
            @else
                <div class="relative group">
                    <button class="text-white hover:text-blue-200 transition flex items-center">
                        <i class="fa-regular fa-user-circle mr-2"></i> {{ Auth::user()->name }}
                        {{-- <i class="fa-solid fa-chevron-down ml-2"></i> --}}
                    </button>
                    {{-- <div
                        class="absolute right-0 w-48 bg-white shadow-md rounded-md py-2 opacity-0 group-hover:opacity-100 invisible group-hover:visible transition duration-300 z-20">
                        <a href="{{ route('profile.dashboard') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-blue-100 transition">Profile</a>
                        <a href="{{ route('profile.orders') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-blue-100 transition">Orders</a>
                        <form method="GET" action="{{ route('user.logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-blue-100 transition">Logout</button>
                        </form>
                    </div> --}}
                </div>
            @endguest
        </div>
    </div>
</nav>
