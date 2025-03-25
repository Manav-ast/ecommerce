@extends('admin.dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-semibold mb-6">Dashboard Overview</h1>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Revenue Card -->
            <x-admin.stats-card title="Total Revenue" value="${{ number_format($totalRevenue, 2) }}" icon="uil uil-money-bill"
                color="bg-green-100 text-green-600" />

            <!-- Total Products Card -->
            <x-admin.stats-card title="Total Products" value="{{ $totalProducts }}" icon="uil uil-box"
                color="bg-blue-100 text-blue-600" />

            <!-- Total Categories Card -->
            <x-admin.stats-card title="Total Categories" value="{{ $totalCategories }}" icon="uil uil-layers"
                color="bg-purple-100 text-purple-600" />

            <!-- Total Orders Card -->
            <x-admin.stats-card title="Total Orders" value="{{ $totalOrders }}" icon="uil uil-shopping-cart"
                color="bg-orange-100 text-orange-600" />
        </div>

        <!-- Chart and Recent Orders Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Revenue Chart -->
            <div class="col-span-1">
                <x-admin.revenue-chart :monthlyRevenue="$monthlyRevenue" />
            </div>

            <!-- Recent Orders -->
            <div class="col-span-1">
                <x-admin.recent-orders :orders="$recentOrders" />
            </div>
        </div>
    </div>
@endsection
