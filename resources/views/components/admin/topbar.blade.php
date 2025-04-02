<!-- resources/views/components/admin/topbar.blade.php -->
<header class="bg-white shadow-md p-3 md:p-4 flex justify-between items-center">
    <div class="flex items-center space-x-2 md:space-x-3">
        <!-- Mobile sidebar toggle -->
        <button @click="sidebarOpen = !sidebarOpen"
            class="md:hidden text-gray-700 hover:text-indigo-600 p-1 rounded-full hover:bg-gray-100">
            <i class="fas fa-bars w-5 h-5 md:w-6 md:h-6"></i>
        </button>
        <div class="flex items-center space-x-2">
            <div class="text-base md:text-lg font-semibold text-gray-800 truncate">E-commerce Admin</div>
            <div class="hidden md:block text-sm text-indigo-600 font-medium">
                Welcome, {{ Auth::guard('admin')->user()->name }}
            </div>
        </div>
    </div>
    <div class="relative" x-data="{ profileOpen: false }">
        <button @click="profileOpen = !profileOpen"
            class="flex items-center space-x-1 md:space-x-2 text-gray-700 hover:text-indigo-600 p-1 rounded-lg hover:bg-gray-50">
            <i class="fas fa-user-circle w-5 h-5 md:w-6 md:h-6"></i>
            <span class="hidden sm:inline text-sm md:text-base">{{ Auth::guard('admin')->user()->name }}</span>
            <i class="fas fa-chevron-down w-4 h-4 md:w-5 md:h-5"></i>
        </button>
        <!-- Dropdown menu with Alpine.js -->
        <div x-show="profileOpen" @click.away="profileOpen = false"
            class="absolute right-0 mt-2 w-40 md:w-48 bg-white rounded-lg shadow-lg z-10 border border-gray-100">
            <a href="#"
                class="block px-3 md:px-4 py-2 text-sm md:text-base text-gray-700 hover:bg-indigo-50">Profile</a>
            <a href="#"
                class="block px-3 md:px-4 py-2 text-sm md:text-base text-gray-700 hover:bg-indigo-50">Logout</a>
        </div>
    </div>
</header>
