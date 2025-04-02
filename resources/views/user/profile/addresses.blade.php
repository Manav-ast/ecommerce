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

                    {{-- <nav class="space-y-2">
                        <a href="{{ route('profile.dashboard') }}"
                            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-700 transition">
                            <i class="fa-solid fa-tachometer-alt w-5 h-5"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('profile.orders') }}"
                            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-700 transition">
                            <i class="fa-solid fa-shopping-bag w-5 h-5"></i>
                            <span>My Orders</span>
                        </a>
                        <a href="{{ route('profile.addresses') }}"
                            class="flex items-center space-x-2 p-2 rounded-lg bg-blue-50 text-blue-700">
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
                    </nav> --}}
                    <x-users.profile-navbar />
                </div>
            </div>

            <!-- Main Content -->
            <div class="w-full md:w-3/4 px-4">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">My Addresses</h1>
                        <button
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                            <i class="fa-solid fa-plus mr-1"></i> Add New Address
                        </button>
                    </div>

                    @if ($user->addresses->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach ($user->addresses as $address)
                                <div class="border border-gray-200 rounded-lg p-4 relative hover:shadow-md transition">
                                    @if ($address->is_default)
                                        <span
                                            class="absolute top-2 right-2 bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">
                                            Default
                                        </span>
                                    @endif
                                    <div class="mb-3">
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $address->type }}</h3>
                                    </div>
                                    <div class="space-y-2 text-gray-600">
                                        <p>{{ $address->address_line1 }}</p>
                                        @if ($address->address_line2)
                                            <p>{{ $address->address_line2 }}</p>
                                        @endif
                                        <p>{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</p>
                                        <p>{{ $address->country }}</p>
                                    </div>
                                    <div class="mt-4 flex space-x-3">
                                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            <i class="fa-solid fa-edit mr-1"></i> Edit
                                        </a>
                                        @if (!$address->is_default)
                                            <a href="#" class="text-gray-600 hover:text-gray-800 text-sm font-medium">
                                                <i class="fa-solid fa-check-circle mr-1"></i> Set as Default
                                            </a>
                                        @endif
                                        <a href="#" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                            <i class="fa-solid fa-trash mr-1"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 bg-gray-50 rounded-lg">
                            <div class="text-5xl text-gray-300 mb-4">
                                <i class="fa-solid fa-map-marker-alt"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-700 mb-2">No Addresses Found</h3>
                            <p class="text-gray-500 mb-6">You haven't added any addresses to your account yet.</p>
                            <button
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                <i class="fa-solid fa-plus mr-1"></i> Add Your First Address
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
