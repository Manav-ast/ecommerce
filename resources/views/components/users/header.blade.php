<header class="py-3 shadow-sm bg-white sticky top-0 z-50">
    <div class="container mx-auto px-6 flex items-center justify-between gap-8">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex-shrink-0">
            <img src="{{ asset('assets/images/logo.svg') }}" alt="Company Logo" class="w-28 h-auto" loading="lazy">
        </a>

        <!-- Search Bar -->
        <div class="flex-grow max-w-2xl relative">
            <form class="relative flex items-center" action="{{ url('/search') }}" method="GET">
                <label for="search" class="sr-only">Search products</label>
                <input type="text" name="search" id="search"
                    class="w-full border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 px-10 py-2.5 rounded-full shadow-sm focus:outline-none text-gray-700 transition-all duration-200"
                    placeholder="Search for products..." aria-label="Search for products" autocomplete="off">
                <button type="button"
                    class="absolute left-3 top-1/2 -translate-y-1/2 text-blue-500 text-base hover:text-blue-700 transition-colors"
                    aria-label="Search icon">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <button type="submit"
                    class="absolute right-1.5 top-1/2 -translate-y-1/2 bg-blue-500 text-white px-5 py-1.5 rounded-full hover:bg-blue-700 transition-all duration-200">
                    Search
                </button>
            </form>
            <div id="search-results"
                class="absolute w-full bg-white mt-1 rounded-lg shadow-lg overflow-hidden hidden z-50"></div>
        </div>

        <!-- Right Section -->
        <div class="flex items-center gap-5">
            <!-- Contact Info -->
            <div class="hidden lg:flex flex-col items-end gap-1 text-gray-700 text-left">
                <a href="tel:+918160868450"
                    class="font-semibold text-xs flex items-center gap-1 hover:text-blue-700 transition-colors ltr">
                    <i class="fas fa-phone-alt fa-flip-horizontal"></i>
                    +91 8160868450
                </a>
                <a href="mailto:manavvaishnani.ast@gmail.com"
                    class="font-semibold text-xs flex items-center gap-1 hover:text-blue-700 transition-colors ltr">
                    <i class="fas fa-envelope"></i> manavvaishnani.ast@gmail.com
                </a>
            </div>



            <!-- User Actions -->
            <nav class="flex items-center gap-6" aria-label="User navigation">
                <!-- Wishlist -->
                {{-- <a href="#" class="group text-gray-700 hover:text-blue-700 transition-colors relative flex flex-col items-center">
                    <div class="text-xl">
                        <i class="fa-regular fa-heart group-hover:scale-110 transition-transform"></i>
                    </div>
                    <span class="text-[10px] mt-0.5">Wishlist</span>
                    <span class="absolute -right-2 -top-0.5 w-4 h-4 rounded-full flex items-center justify-center bg-blue-500 group-hover:bg-blue-700 text-white text-[9px]">
                        8
                    </span>
                </a> --}}

                <!-- Cart Icon -->
                <a href="{{ url('/cart') }}"
                    class="group text-gray-700 hover:text-blue-700 transition-colors relative flex flex-col items-center">
                    <div class="text-xl">
                        <i class="fa-solid fa-bag-shopping group-hover:scale-110 transition-transform"></i>
                    </div>
                    <span class="text-[10px] mt-0.5">Cart</span>
                    <span id="cart-count"
                        class="absolute -right-2.5 -top-0.5 w-4 h-4 rounded-full flex items-center justify-center bg-blue-500 group-hover:bg-blue-700 text-white text-[9px] 
                        {{ session('cart_count', 0) == 0 ? 'hidden' : '' }}">
                        {{ session('cart_count', 0) }}
                    </span>
                </a>



                <!-- Account -->
                @guest
                    <a href="{{ url('/register') }}"
                        class="group text-gray-700 hover:text-blue-700 transition-colors relative flex flex-col items-center">
                        <div class="text-xl">
                            <i class="fa-regular fa-user group-hover:scale-110 transition-transform"></i>
                        </div>
                        <span class="text-[10px] mt-0.5">Register</span>
                    </a>
                @else
                    <a href="{{ url('/profile') }}"
                        class="group text-gray-700 hover:text-blue-700 transition-colors relative flex flex-col items-center">
                        <div class="text-xl">
                            <i class="fa-regular fa-user group-hover:scale-110 transition-transform"></i>
                        </div>
                        <span class="text-[10px] mt-0.5">Profile</span>
                    </a>
                @endguest
            </nav>
        </div>
    </div>
</header>
