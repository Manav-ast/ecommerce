<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
        

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="bg-white">
        <div class="flex">
            <!-- Sidebar -->
            <aside class="w-72 bg-white h-screen shadow-sm fixed flex flex-col justify-between">
                <!-- Logo Section -->
                <div>
                    <div class="p-4 flex items-center space-x-2">
                        <img src="{{ Vite::asset('resources/images/freshcart-logo.svg') }}" class="h-8 w-auto" alt="Logo">
                    </div>
                    
                    {{-- <!-- Search -->
                    <div class="px-4">
                        <input type="text" placeholder="Search" 
                               class="w-full px-3 py-2 border rounded-md focus:ring-green-400 focus:border-green-400">
                    </div> --}}
                
                    <!-- Navigation -->
                    <nav class="mt-4 px-4">
                        <ul class="space-y-2">
                            <li>
                                <x-admin.nav-link href="/dashboard" :active="request()->is('dashboard')">
                                    <i class="mdi mdi-view-dashboard mr-2"></i> Dashboard
                                </x-admin.nav-link>
                            </li>

                            <p class="text-sm text-gray-500 mt-4">Store Managements</p>

                            <li>
                                <x-admin.nav-link href="/dashboard/product" :active="request()->is('dashboard/product')">
                                    <i class="mdi mdi-shopping mr-2"></i> Products
                                </x-admin.nav-link>                               
                            </li>

                            <li>
                                <x-admin.nav-link href="/dashboard/categories" :active="request()->is('dashboard/categories')">
                                    <i class="mdi mdi-format-list-bulleted mr-2"></i> Categories
                                </x-admin.nav-link> 
                            </li>

                            <li>
                                <x-admin.nav-link href="/dashboard/orders" :active="request()->is('dashboard/orders')">
                                    <i class="mdi mdi-cart mr-2"></i> Orders
                                </x-admin.nav-link> 
                            </li>
                            
                            <li>
                                <x-admin.nav-link href="/dashboard/customers" :active="request()->is('dashboard/customers')">
                                    <i class="mdi mdi-account-group mr-2"></i> Customers
                                </x-admin.nav-link> 
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- Logout & Profile -->
                <div class="p-4">
                    <div class="flex items-center space-x-2">
                        <img src="https://avatars.dicebear.com/v2/initials/john-doe.svg" class="h-8 w-8 rounded-full" alt="User">
                        <div>
                            <p class="text-sm font-medium">John Doe</p>
                            <p class="text-xs text-gray-500">Admin</p>
                        </div>
                    </div>
                    <div class="mt-4 space-y-2">
                        <x-admin.nav-link href="/profile" :active="request()->is('profile')">
                            <i class="mdi mdi-account-circle mr-2"></i> Profile
                        </x-admin.nav-link>
                        
                        <x-admin.nav-link href="/logout" :active="request()->is('logout')" class="text-red-600">
                            <i class="mdi mdi-logout mr-2"></i> Logout
                        </x-admin.nav-link>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="ml-72 w-full p-6">
                {{ $slot }}
            </main>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    </body>
</html>