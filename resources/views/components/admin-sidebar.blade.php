<aside class="w-64 bg-white shadow-lg min-h-screen flex flex-col justify-between p-4">
    <!-- Sidebar Header -->
    <div>
        <div class="pb-4 border-b text-center pl-2">
            <a href="{{ route('admin.dashboard') }}" class="flex-shrink-0">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="Company Logo" class="w-28 h-auto" loading="lazy">
            </a>
        </div>

        <!-- Sidebar Navigation -->
        <nav class="mt-6">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-700 hover:text-white transition 
                        {{ request()->routeIs('admin.dashboard') ? 'bg-blue-500 text-white' : '' }}">
                        <i class="uil uil-create-dashboard text-lg"></i>
                        <span class="ml-4">Dashboard</span>
                    </a>
                </li>
                <hr class="my-2">
                <li>
                    <a href="{{ route('admin.categories') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-700 hover:text-white transition 
                        {{ request()->routeIs('admin.categories') ? 'bg-blue-500 text-white' : '' }}">
                        <i class="uil uil-folder text-lg"></i>
                        <span class="ml-4">Category</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-700 hover:text-white transition 
                        {{ request()->routeIs('admin.products') ? 'bg-blue-500 text-white' : '' }}">
                        <i class="uil uil-shopping-cart text-lg"></i>
                        <span class="ml-4">Products</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-700 hover:text-white transition 
                        {{ request()->routeIs('admin.orders') ? 'bg-blue-500 text-white' : '' }}">
                        <i class="uil uil-box text-lg"></i>
                        <span class="ml-4">Orders</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-700 hover:text-white transition 
                        {{ request()->routeIs('admin.users') ? 'bg-blue-500 text-white' : '' }}">
                        <i class="uil uil-users-alt text-lg"></i>
                        <span class="ml-4">Users</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.roles.index') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-700 hover:text-white transition 
                        {{ request()->routeIs('admin.roles.index') ? 'bg-blue-500 text-white' : '' }}">
                        <i class="uil uil-user-circle text-lg"></i>
                        <span class="ml-4">Roles</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.static_blocks.index') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-700 hover:text-white transition 
                        {{ request()->routeIs('admin.static_blocks.index') ? 'bg-blue-500 text-white' : '' }}">
                        <i class="uil uil-file-alt text-lg"></i>
                        <span class="ml-4">Static Blocks</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Settings (Pinned at Bottom) -->
    <div class="mt-auto pt-4">
        <hr class="mb-2">
        <ul>
            <li>
                <a href="{{ route('admin.logout') }}"
                    class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-red-600 transition bg-red-500 
                    {{ request()->routeIs('admin.logout') ? 'bg-red-500 text-white' : '' }}">
                    <i class="uil uil-signout"></i>
                    <span class="ml-4">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
