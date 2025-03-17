<aside class="w-64 bg-white shadow-lg min-h-screen flex flex-col justify-between p-4">
    <!-- Sidebar Header -->
    <div>
        <div class="pb-4 border-b">
            <h2 class="text-2xl font-bold text-gray-800 text-center">Admin Panel</h2>
        </div>

        <!-- Sidebar Navigation -->
        <nav class="mt-6">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('admin.dashboard') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-100 transition 
                        {{ request()->routeIs('admin.dashboard') ? 'bg-blue-500 text-white' : '' }}">
                        <i class="uil uil-create-dashboard text-lg"></i>
                        <span class="ml-4">Dashboard</span>
                    </a>
                </li>
                <hr class="my-2">
                <li>
                    <a href="{{ route('admin.categories') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-100 transition 
                        {{ request()->is('Category') ? 'bg-blue-500 text-white' : '' }}">
                        <i class="uil uil-folder text-lg"></i>
                        <span class="ml-4">Category</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-100 transition 
                        {{ request()->is('Products') ? 'bg-blue-500 text-white' : '' }}">
                        <i class="uil uil-shopping-cart text-lg"></i>
                        <span class="ml-4">Products</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('admin.orders') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-100 transition 
                        {{ request()->is('Orders') ? 'bg-blue-500 text-white' : '' }}">
                        <i class="uil uil-box text-lg"></i>
                        <span class="ml-4">Orders</span>
                    </a>
                </li> --}}
                <li>
                    <a href="{{ route('admin.users') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-100 transition 
                        {{ request()->is('Users') ? 'bg-blue-500 text-white' : '' }}">
                        <i class="uil uil-users-alt text-lg"></i>
                        <span class="ml-4">Users</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Settings (Pinned at Bottom) -->
    <div class="mt-auto pt-4">
        <hr class="mb-2">
        <ul>
            {{-- <li>
                <a href="{{ route('admin.settings') }}" 
                    class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-100 transition 
                    {{ request()->is('setting') ? 'bg-blue-500 text-white' : '' }}">
                    <i class="uil uil-setting text-lg"></i>
                    <span class="ml-4">Settings</span>
                </a>
            </li> --}}
        </ul>
    </div>
</aside>
