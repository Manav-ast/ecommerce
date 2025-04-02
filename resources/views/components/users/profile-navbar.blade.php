<nav class="space-y-2">
    <a href="{{ route('profile.dashboard') }}"
        class="flex items-center space-x-2 p-2 rounded-lg {{ request()->routeIs('profile.dashboard') ? 'bg-blue-50 text-blue-700' : 'hover:bg-blue-50 text-gray-700 hover:text-blue-700' }} transition">
        <i class="fa-solid fa-tachometer-alt w-5 h-5"></i>
        <span>Dashboard</span>
    </a>
    <a href="{{ route('profile.orders') }}"
        class="flex items-center space-x-2 p-2 rounded-lg {{ request()->routeIs('profile.orders') ? 'bg-blue-50 text-blue-700' : 'hover:bg-blue-50 text-gray-700 hover:text-blue-700' }} transition">
        <i class="fa-solid fa-shopping-bag w-5 h-5"></i>
        <span>My Orders</span>
    </a>
    <a href="{{ route('profile.addresses') }}"
        class="flex items-center space-x-2 p-2 rounded-lg {{ request()->routeIs('profile.addresses') ? 'bg-blue-50 text-blue-700' : 'hover:bg-blue-50 text-gray-700 hover:text-blue-700' }} transition">
        <i class="fa-solid fa-map-marker-alt w-5 h-5"></i>
        <span>Addresses</span>
    </a>
    <form method="GET" action="{{ route('user.logout') }}" class="mt-4">
        @csrf
        <button type="submit"
            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-red-50 text-gray-700 hover:text-red-700 transition w-full">
            <i class="fa-solid fa-sign-out-alt w-5 h-5"></i>
            <span>Logout</span>
        </button>
    </form>
</nav>