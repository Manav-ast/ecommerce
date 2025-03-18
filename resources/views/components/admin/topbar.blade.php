<!-- resources/views/components/admin/topbar.blade.php -->
<header class="bg-white shadow-md p-4 flex justify-between items-center">
    <div class="text-lg font-semibold text-gray-800">E-commerce Admin</div>
    <div class="relative">
        <button class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600">
            <i class="fas fa-user-circle w-6 h-6"></i>
            <span>Admin User</span>
            <i class="fas fa-chevron-down w-5 h-5"></i>
        </button>
        <!-- Dropdown (static for now) -->
        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg hidden">
            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Profile</a>
            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Logout</a>
        </div>
    </div>
</header>