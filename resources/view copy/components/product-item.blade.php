<div class="flex items-center justify-between border-b pb-4">
    <label for="counter-input" class="sr-only">Choose quantity:</label>

    <div class="flex items-center space-x-4">
        <img src="{{ Vite::asset('resources/images/products/product-img-1.jpg') }}" class="w-20 h-20 rounded-lg object-cover" alt="Product">
        <div>
            <h3 class="text-lg font-semibold text-gray-900">Organic Apples</h3>
            <p class="text-gray-500">Fresh and organic apples from the farm.</p>
            <p class="text-gray-900 font-semibold">$5.99</p>
        </div>
    </div>

    <!-- Quantity Controls -->
    <div class="flex items-center space-x-2">
        <button type="button" id="decrement-button-2" data-input-counter-decrement="counter-input-2" class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100">
            <svg class="h-2.5 w-2.5 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
            </svg>
          </button>
          <input type="text" id="counter-input-2" data-input-counter class="w-10 shrink-0 border-0 bg-transparent text-center text-sm font-medium text-gray-900 focus:outline-none focus:ring-0 " placeholder="" value="1" required />
            <button type="button" id="increment-button-2" data-input-counter-increment="counter-input-2" class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100">
        <svg class="h-2.5 w-2.5 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
        </svg>
        </div>

    <!-- Remove Button -->
    <button type="button" class="inline-flex items-center text-sm font-medium text-red-600 hover:underline dark:text-red-500">
        <svg class="me-1.5 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
        </svg>
        Remove
      </button>
</div>