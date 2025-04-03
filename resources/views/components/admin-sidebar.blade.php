<aside class="w-64 bg-white shadow-lg min-h-screen flex flex-col justify-between p-4 overflow-auto">
    <!-- Sidebar Header -->
    <div>
        <div class="pb-4 border-b text-center pl-2">
            <a href="{{ route('admin.dashboard') }}" class="flex-shrink-0">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="Company Logo" class="w-28 h-auto md:w-28 sm:w-24" loading="lazy">
            </a>
        </div>

        <!-- Sidebar Navigation -->
        <nav class="mt-6 md:mt-6 sm:mt-4">
            <ul class="space-y-2 md:space-y-2 sm:space-y-1">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-4 py-3 md:py-3 sm:py-2 text-gray-700 md:text-base sm:text-sm rounded-lg hover:bg-blue-700 hover:text-white transition 
                        {{ request()->routeIs('admin.dashboard') ? 'bg-blue-500 text-white' : '' }}">
                        <i class="uil uil-create-dashboard text-lg md:text-lg sm:text-base"></i>
                        <span class="ml-4 md:ml-4 sm:ml-2">Dashboard</span>
                    </a>
                </li>
                <hr class="my-2 md:my-2 sm:my-1">
                @can('manage_categories')
                    <li>
                        <a href="{{ route('admin.categories') }}"
                            class="flex items-center px-4 py-3 md:py-3 sm:py-2 text-gray-700 md:text-base sm:text-sm rounded-lg hover:bg-blue-700 hover:text-white transition 
                        {{ request()->routeIs('admin.categories') ? 'bg-blue-500 text-white' : '' }}">
                            <i class="uil uil-folder text-lg md:text-lg sm:text-base"></i>
                            <span class="ml-4 md:ml-4 sm:ml-2">Category</span>
                        </a>
                    </li>
                @endcan

                @can('manage_products')
                    <li>
                        <a href="{{ route('admin.products') }}"
                            class="flex items-center px-4 py-3 md:py-3 sm:py-2 text-gray-700 md:text-base sm:text-sm rounded-lg hover:bg-blue-700 hover:text-white transition 
                        {{ request()->routeIs('admin.products') ? 'bg-blue-500 text-white' : '' }}">
                            <i class="uil uil-shopping-cart text-lg md:text-lg sm:text-base"></i>
                            <span class="ml-4 md:ml-4 sm:ml-2">Products</span>
                        </a>
                    </li>
                @endcan

                @can('manage_orders')
                    <li>
                        <a href="{{ route('admin.orders') }}"
                            class="flex items-center px-4 py-3 md:py-3 sm:py-2 text-gray-700 md:text-base sm:text-sm rounded-lg hover:bg-blue-700 hover:text-white transition 
                        {{ request()->routeIs('admin.orders') ? 'bg-blue-500 text-white' : '' }}">
                            <i class="uil uil-box text-lg md:text-lg sm:text-base"></i>
                            <span class="ml-4 md:ml-4 sm:ml-2">Orders</span>
                        </a>
                    </li>
                @endcan

                @can('manage_users')
                    <li>
                        <a href="{{ route('admin.users') }}"
                            class="flex items-center px-4 py-3 md:py-3 sm:py-2 text-gray-700 md:text-base sm:text-sm rounded-lg hover:bg-blue-700 hover:text-white transition 
                        {{ request()->routeIs('admin.users') ? 'bg-blue-500 text-white' : '' }}">
                            <i class="uil uil-users-alt text-lg md:text-lg sm:text-base"></i>
                            <span class="ml-4 md:ml-4 sm:ml-2">Users</span>
                        </a>
                    </li>
                @endcan

                @can('manage_admins')
                    <li>
                        <a href="{{ route('admin.admins.index') }}"
                            class="flex items-center px-4 py-3 md:py-3 sm:py-2 text-gray-700 md:text-base sm:text-sm rounded-lg hover:bg-blue-700 hover:text-white transition 
                        {{ request()->routeIs('admin.admins.index') ? 'bg-blue-500 text-white' : '' }}">
                            <i class="uil uil-users-alt text-lg md:text-lg sm:text-base"></i>
                            <span class="ml-4 md:ml-4 sm:ml-2">Admins</span>
                        </a>
                    </li>
                @endcan
                
                @can('manage_roles')
                    <li>
                        <a href="{{ route('admin.roles') }}"
                            class="flex items-center px-4 py-3 md:py-3 sm:py-2 text-gray-700 md:text-base sm:text-sm rounded-lg hover:bg-blue-700 hover:text-white transition 
                        {{ request()->routeIs('admin.roles') ? 'bg-blue-500 text-white' : '' }}">
                            <i class="uil uil-user-circle text-lg md:text-lg sm:text-base"></i>
                            <span class="ml-4 md:ml-4 sm:ml-2">Roles</span>
                        </a>
                    </li>
                @endcan

                @can('manage_static_blocks')
                    <li>
                        <a href="{{ route('admin.static-blocks.index') }}"
                            class="flex items-center px-4 py-3 md:py-3 sm:py-2 text-gray-700 md:text-base sm:text-sm rounded-lg hover:bg-blue-700 hover:text-white transition 
                        {{ request()->routeIs('admin.static-blocks') ? 'bg-blue-500 text-white' : '' }}">
                            <i class="uil uil-file-alt text-lg md:text-lg sm:text-base"></i>
                            <span class="ml-4 md:ml-4 sm:ml-2">Static Blocks</span>
                        </a>
                    </li>
                @endcan

                @can('manage_page_blocks')
                    <li>
                        <a href="{{ route('admin.page-blocks.index') }}"
                            class="flex items-center px-4 py-3 md:py-3 sm:py-2 text-gray-700 md:text-base sm:text-sm rounded-lg hover:bg-blue-700 hover:text-white transition 
                        {{ request()->routeIs('admin.page-blocks.index') ? 'bg-blue-500 text-white' : '' }}">
                            <i class="uil uil-file-alt text-lg md:text-lg sm:text-base"></i>
                            <span class="ml-4 md:ml-4 sm:ml-2">Page Blocks</span>
                        </a>
                    </li>
                @endcan
                
                <!-- Mobile Logout (Visible only on small screens) -->
                <li class="md:hidden block mt-4">
                    <a href="{{ route('admin.logout') }}"
                        class="flex items-center px-4 py-2 text-white text-sm rounded-lg bg-red-500 hover:bg-red-600 transition">
                        <i class="uil uil-signout text-base"></i>
                        <span class="ml-2">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Settings (Pinned at Bottom) - Hidden on mobile since we added mobile version above -->
    <div class="mt-auto pt-4 md:pt-4 sm:pt-2 hidden md:block">
        <hr class="mb-2 md:mb-2 sm:mb-1">
        <ul>
            <li>
                <a href="{{ route('admin.logout') }}"
                    class="flex items-center px-4 py-3 md:py-3 sm:py-2 text-white md:text-base sm:text-sm rounded-lg hover:bg-red-600 transition bg-red-500 
                    {{ request()->routeIs('admin.logout') ? 'bg-red-500 text-white' : '' }}">
                    <i class="uil uil-signout md:text-lg sm:text-base"></i>
                    <span class="ml-4 md:ml-4 sm:ml-2">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>