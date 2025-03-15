    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-gray-100">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">




        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="bg-white">
        <nav class="bg-white">
            <div class="max-w-screen-xl mx-auto px-2 py-4 flex justify-between items-center">

                <!-- Logo -->
                <a href="/">
                    <img class="w-auto h-8" src="{{ Vite::asset('resources/images/freshcart-logo.svg') }}"
                        alt="Logo">
                </a>

                <!-- Desktop Menu -->
                <div class="flex space-x-6">
                    <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
                    <x-nav-link href="/contact" :active="request()->is('contact')">Contact</x-nav-link>
                    <x-nav-link href="/products" :active="request()->is('products')">Product</x-nav-link>
                    <x-nav-link href="/categories" :active="request()->is('categories')">Categories</x-nav-link>
                </div>

                <!-- Icons (Cart & Account) -->
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="#" class="flex items-center space-x-1 p-2 hover:bg-gray-200 rounded-lg">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
                            </svg>
                            <span class="hidden sm:inline">Cart</span>
                        </a>
                        <a href="#" class="flex items-center space-x-1 p-2 hover:bg-gray-200 rounded-lg">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-width="2"
                                    d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <span class="hidden sm:inline">Account</span>
                        </a>
                    @endauth
                    @guest
                        <x-nav-link href="/login" :active="request()->is('/login')">Login</x-nav-link>
                        <x-nav-link href="/register" :active="request()->is('/register')">Register</x-nav-link>
                    @endguest
                </div>



            </div>
        </nav>

        <x-divider />

        <!-- Main Content -->
        <main class="max-w-screen-xl mx-auto p-6">
            {{ $slot }}
        </main>

        {{-- <footer class="bg-gray-100 text-center py-4">
                <p class="text-gray-600 text-sm">© 2025 FreshCart. All rights reserved.</p>
            </footer> --}}
        <footer class="bg-gray-200 w-full py-10">
            <div class="max-w-screen-2xl mx-auto px-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

                    <!-- About Us -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">About Us</h3>
                        <p class="text-gray-700 text-sm">
                            FreshCart is your one-stop online store for fresh groceries, organic produce, and daily
                            essentials.
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Quick Links</h3>
                        <ul class="text-gray-700 text-sm space-y-2">
                            <li><a href="/" class="hover:text-green-600">Home</a></li>
                            <li><a href="/shop" class="hover:text-green-600">Shop</a></li>
                            <li><a href="/about" class="hover:text-green-600">About Us</a></li>
                            <li><a href="/contact" class="hover:text-green-600">Contact</a></li>
                        </ul>
                    </div>

                    <!-- Newsletter -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Newsletter</h3>
                        <p class="text-gray-700 text-sm">Subscribe to get the latest deals and offers!</p>
                        <form class="mt-4">
                            <input type="email" placeholder="Enter your email"
                                class="w-full px-3 py-2 border border-gray-400 bg-white text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            <button type="submit"
                                class="mt-2 w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-500">Subscribe</button>
                        </form>
                    </div>

                </div>

                <!-- Divider -->
                <div class="mt-10 border-t border-gray-300 pt-4 text-center text-sm text-gray-700">
                    © 2025 FreshCart. All rights reserved.
                </div>
            </div>
        </footer>


        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    </body>

    </html>
