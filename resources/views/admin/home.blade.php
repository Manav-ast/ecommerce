@extends('layouts.admin.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container mx-auto px-3 md:px-4 py-4 md:py-6">
        <h1 class="text-xl md:text-2xl font-semibold text-gray-800 mb-4 md:mb-6">Dashboard Overview</h1>

        <!-- Stats Cards Row - Responsive Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6 mb-6 md:mb-8">
            <x-admin.stats-card title="Total Orders" value="{{ $totalOrders }}" icon="fas fa-shopping-cart"
                color="bg-blue-100 text-blue-600" />

            <x-admin.stats-card title="Total Revenue" value="${{ number_format($totalRevenue, 2) }}" icon="fas fa-dollar-sign"
                color="bg-green-100 text-green-600" />

            <x-admin.stats-card title="Total Products" value="{{ $totalProducts }}" icon="fas fa-box"
                color="bg-purple-100 text-purple-600" />

            <x-admin.stats-card title="Total Users" value="{{ $totalUsers }}" icon="fas fa-users"
                color="bg-orange-100 text-orange-600" />
        </div>

        <!-- Charts and Tables Row - Responsive Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
            <!-- Revenue Chart -->
            <div class="mb-4 lg:mb-0">
                <x-admin.revenue-chart :monthlyRevenue="$monthlyRevenue" />
            </div>

            <!-- Recent Orders -->
            <div>
                <x-admin.recent-orders :orders="$recentOrders" />
            </div>
        </div>
    </div>
@endsection
