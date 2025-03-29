@extends('layouts.users.app')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="flex flex-wrap -mx-4">
            <!-- Sidebar -->
            <div class="w-full md:w-1/4 px-4 mb-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex flex-col items-center text-center mb-6">
                        <div
                            class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 text-3xl mb-3">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h2>
                        <p class="text-gray-600 text-sm">{{ $user->email }}</p>
                    </div>

                    <hr class="my-4">

                    <nav class="space-y-2">
                        <a href="{{ route('profile.dashboard') }}"
                            class="flex items-center space-x-2 p-2 rounded-lg bg-blue-50 text-blue-700">
                            <i class="fa-solid fa-tachometer-alt w-5 h-5"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('profile.orders') }}"
                            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-700 transition">
                            <i class="fa-solid fa-shopping-bag w-5 h-5"></i>
                            <span>My Orders</span>
                        </a>
                        <a href="#"
                            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-700 transition">
                            <i class="fa-solid fa-user-edit w-5 h-5"></i>
                            <span>Account Details</span>
                        </a>
                        <a href="{{ route('profile.addresses') }}"
                            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-700 transition">
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
                </div>
            </div>

            <!-- Main Content -->
            <div class="w-full md:w-3/4 px-4">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6">Welcome, {{ $user->name }}!</h1>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Recent Orders Summary -->
                        <div class="bg-blue-50 rounded-lg p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-lg font-semibold text-gray-800">Recent Orders</h2>
                                <a href="{{ route('profile.orders') }}"
                                    class="text-blue-600 hover:text-blue-800 text-sm">View All</a>
                            </div>
                            @php
                                $recentOrders = \App\Models\Order::where('user_id', $user->id)
                                    ->latest()
                                    ->take(3)
                                    ->get();
                            @endphp

                            @if ($recentOrders->count() > 0)
                                <div class="space-y-3">
                                    @foreach ($recentOrders as $order)
                                        <div class="flex justify-between items-center p-3 bg-white rounded-lg shadow-sm">
                                            <div>
                                                <p class="font-medium text-gray-800">Order #{{ $order->id }}</p>
                                                <p class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y') }}
                                                </p>
                                            </div>
                                            <div>
                                                <span
                                                    class="px-2 py-1 rounded-full text-xs font-medium {{ $order->order_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : ($order->order_status == 'shipped' ? 'bg-blue-100 text-blue-800' : ($order->order_status == 'delivered' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')) }}">
                                                    {{ ucfirst($order->order_status) }}
                                                </span>
                                                <p class="text-right font-medium text-gray-800 mt-1">
                                                    ${{ number_format($order->total_price, 2) }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <p class="text-gray-600">You haven't placed any orders yet.</p>
                                    <a href="{{ route('shop.index') }}"
                                        class="mt-3 inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Start
                                        Shopping</a>
                                </div>
                            @endif
                        </div>

                        <!-- Account Summary -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Account Information</h2>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-600">Name</p>
                                    <p class="font-medium text-gray-800">{{ $user->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Email</p>
                                    <p class="font-medium text-gray-800">{{ $user->email }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Phone</p>
                                    <p class="font-medium text-gray-800">{{ $user->phone_no ?? 'Not provided' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Member Since</p>
                                    <p class="font-medium text-gray-800">{{ $user->created_at->format('F Y') }}</p>
                                </div>
                            </div>
                            <div class="mt-6">
                                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit Account
                                    Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
