@props(['image', 'name', 'availability', 'quantity', 'price', 'productId'])

<div
    class="flex items-center justify-between bg-white border border-gray-200 p-4 rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
    <div class="flex items-center">
        <img src="{{ asset($image) }}" alt="{{ $name }}" class="w-16 h-16 rounded-lg object-cover">
        <div class="ml-4">
            <h3 class="text-sm font-semibold text-gray-800">{{ $name }}</h3>
            <p class="text-xs text-gray-500">Availability:
                <span class="text-green-500 font-medium">{{ $availability }}</span>
            </p>
        </div>
    </div>
    <div class="flex items-center space-x-4">
        <div class="flex items-center space-x-2">
            <button onclick="updateCart({{ $productId }}, 'decrease')"
                class="bg-gray-200 px-3 py-1 rounded-lg hover:bg-gray-300 text-gray-800 font-semibold transition-all duration-200">-</button>
            <input type="number" value="{{ $quantity }}"
                class="w-12 border border-gray-300 text-center rounded-md px-1 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                readonly>
            <button onclick="updateCart({{ $productId }}, 'increase')"
                class="bg-gray-200 px-3 py-1 rounded-lg hover:bg-gray-300 text-gray-800 font-semibold transition-all duration-200">+</button>
        </div>
        <div class="text-blue-500 font-bold text-lg">${{ number_format($price, 2) }}</div>
        <button onclick="removeFromCart({{ $productId }})"
            class="text-gray-500 hover:text-blue-600 transition-all duration-200 text-xl">
            <i class="fas fa-trash-alt"></i>
        </button>
    </div>
</div>
