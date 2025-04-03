@props(['image', 'name', 'availability', 'quantity', 'price', 'productId'])

<div class="bg-white border border-gray-200 p-4 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 w-full sm:flex sm:justify-between sm:items-center">
    
    <!-- Product Image & Details -->
    <div class="flex items-center space-x-3 sm:w-1/2">
        <img src="{{ asset($image) }}" alt="{{ $name }}" class="w-16 h-16 rounded-lg object-cover">
        <div>
            <h3 class="text-sm font-semibold text-gray-800 leading-tight">{{ $name }}</h3>
            <p class="text-xs text-gray-500">Availability:  
                <span class="text-green-500 font-medium">{{ $availability }}</span>
            </p>
        </div>
    </div>

    <!-- Quantity, Price, Remove Button -->
    <div class="grid grid-cols-3 sm:flex sm:items-center sm:w-1/2 gap-2 mt-4 sm:mt-0 sm:justify-end sm:space-x-4">
        
        <!-- Quantity Selector -->
        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden min-w-[100px]">
            <button onclick="updateCart({{ $productId }}, 'decrease')"
                class="bg-gray-100 px-3 py-1 text-gray-700 hover:bg-gray-200 transition">-</button>
            <input type="text" value="{{ $quantity }}"
                class="w-10 text-center border-0 text-sm focus:ring-0 bg-white outline-none pointer-events-none">
            <button onclick="updateCart({{ $productId }}, 'increase')"
                class="bg-gray-100 px-3 py-1 text-gray-700 hover:bg-gray-200 transition">+</button>
        </div>

        <!-- Price -->
        <div class="text-blue-500 font-bold text-center text-sm sm:text-lg min-w-[80px]">${{ number_format($price, 2) }}</div>

        <!-- Remove Button -->
        <button onclick="removeFromCart({{ $productId }})"
            class="text-gray-500 hover:text-red-500 transition-all duration-200">
            <i class="fas fa-trash-alt text-lg"></i>
        </button>
    </div>

</div>
