<x-layout>
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-semibold text-gray-900 mb-6">Shopping Cart</h2>
    
        <div class="bg-gray-50 shadow-md rounded-xl p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Cart Items -->
                <div class="md:col-span-2">
                    <div class="space-y-4">
                        <x-product-item/>
                        {{-- <div>
                            <h1>Nothing in Cart</h1>
                        </div> --}}
                    </div>
                </div>
    
                <!-- Order Summary -->
                <div class="bg-white border border-gray-200 p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Order Summary</h3>
                    <div class="flex justify-between mb-3">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold text-gray-900">$9.48</span>
                    </div>
                    <div class="flex justify-between mb-3">
                        <span class="text-gray-600">Tax</span>
                        <span class="font-semibold text-gray-900">$0.95</span>
                    </div>
                    <div class="flex justify-between border-t pt-3">
                        <span class="text-lg font-semibold text-gray-900">Total</span>
                        <span class="text-lg font-semibold text-gray-900">$10.43</span>
                    </div>
                    <button class="mt-4 w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition font-medium">
                        Proceed to Checkout
                    </button>
                </div>
            </div>
            <div>
                <div class="">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-6">Products</h3>
                </div>
                <x-product-card/>
            </div>
           
        </div>
    </div>
    </x-layout>
    