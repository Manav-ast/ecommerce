<!-- resources/views/components/admin/sidebar.blade.php -->
<aside class="h-full bg-white shadow-md p-3 md:p-6 flex flex-col overflow-y-auto">
    <div class="flex items-center justify-between mb-4 md:mb-6">
        <h2 class="text-lg md:text-xl font-semibold text-gray-800">Admin Panel</h2>
        <button @click="sidebarOpen = false"
            class="md:hidden text-gray-500 hover:text-gray-700 p-1 rounded-full hover:bg-gray-100">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <nav class="space-y-1 md:space-y-2 w-full">
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center space-x-3 p-2 md:p-3 rounded-lg hover:bg-indigo-50 text-gray-700 hover:text-indigo-600 transition w-full">
            <i class="fas fa-tachometer-alt w-5 h-5 flex-shrink-0"></i>
            <span class="text-sm md:text-base truncate">Dashboard</span>
        </a>
        <a href="{{ route('admin.products') }}"
            class="flex items-center space-x-3 p-2 md:p-3 rounded-lg hover:bg-indigo-50 text-gray-700 hover:text-indigo-600 transition w-full">
            <i class="fas fa-box w-5 h-5 flex-shrink-0"></i>
            <span class="text-sm md:text-base truncate">Products</span>
        </a>
        <a href="{{ route('admin.orders') }}"
            class="flex items-center space-x-3 p-2 md:p-3 rounded-lg hover:bg-indigo-50 text-gray-700 hover:text-indigo-600 transition w-full">
            <i class="fas fa-shopping-cart w-5 h-5 flex-shrink-0"></i>
            <span class="text-sm md:text-base truncate">Orders</span>
        </a>
        <a href="{{ route('admin.categories') }}"
            class="flex items-center space-x-3 p-2 md:p-3 rounded-lg hover:bg-indigo-50 text-gray-700 hover:text-indigo-600 transition w-full">
            <i class="fas fa-folder w-5 h-5 flex-shrink-0"></i>
            <span class="text-sm md:text-base truncate">Categories</span>
        </a>
        <a href="{{ route('admin.users') }}"
            class="flex items-center space-x-3 p-2 md:p-3 rounded-lg hover:bg-indigo-50 text-gray-700 hover:text-indigo-600 transition w-full">
            <i class="fas fa-users w-5 h-5 flex-shrink-0"></i>
            <span class="text-sm md:text-base truncate">Users</span>
        </a>
    </nav>
</aside>
