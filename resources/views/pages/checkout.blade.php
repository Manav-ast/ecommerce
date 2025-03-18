@extends('layouts.users.app')

@section('content')
<div class="container grid grid-cols-12 items-start gap-6 pb-16 pt-4" role="main">
    <form action="" method="POST" class="col-span-8 border border-gray-200 p-6 rounded bg-white shadow-sm">
        @csrf
        
        
        <h3 class="text-xl font-semibold capitalize mb-6">Checkout</h3>
        
        <!-- Billing Information -->
        <fieldset class="space-y-6">
            <legend class="text-lg font-medium mb-4">Billing Details</legend>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="first-name" class="block text-gray-600 mb-1">First Name <span class="text-red-500" aria-hidden="true">*</span><span class="sr-only">(required)</span></label>
                    <input 
                        type="text" 
                        name="first_name" 
                        id="first-name" 
                        class="input-box w-full" 
                        value="{{ old('first_name') }}"
                        required 
                        aria-required="true"
                        placeholder="John">
                    @error('first_name')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="last-name" class="block text-gray-600 mb-1">Last Name <span class="text-red-500" aria-hidden="true">*</span><span class="sr-only">(required)</span></label>
                    <input 
                        type="text" 
                        name="last_name" 
                        id="last-name" 
                        class="input-box w-full" 
                        value="{{ old('last_name') }}"
                        required 
                        aria-required="true"
                        placeholder="Doe">
                    @error('last_name')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div>
                <label for="company" class="block text-gray-600 mb-1">Company <span class="text-gray-400">(optional)</span></label>
                <input 
                    type="text" 
                    name="company" 
                    id="company" 
                    class="input-box w-full" 
                    value="{{ old('company') }}"
                    placeholder="Your company name">
            </div>

            <div>
                <label for="region" class="block text-gray-600 mb-1">Country/Region <span class="text-red-500" aria-hidden="true">*</span><span class="sr-only">(required)</span></label>
                <select 
                    name="region" 
                    id="region" 
                    class="input-box w-full" 
                    required 
                    aria-required="true">
                    <option value="">Select a country</option>
                    <!-- Add country options here -->
                </select>
                @error('region')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="address" class="block text-gray-600 mb-1">Street Address <span class="text-red-500" aria-hidden="true">*</span><span class="sr-only">(required)</span></label>
                <input 
                    type="text" 
                    name="address" 
                    id="address" 
                    class="input-box w-full" 
                    value="{{ old('address') }}"
                    required 
                    aria-required="true"
                    placeholder="123 Main St">
                @error('address')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="city" class="block text-gray-600 mb-1">City <span class="text-red-500" aria-hidden="true">*</span><span class="sr-only">(required)</span></label>
                    <input 
                        type="text" 
                        name="city" 
                        id="city" 
                        class="input-box w-full" 
                        value="{{ old('city') }}"
                        required 
                        aria-required="true"
                        placeholder="New York">
                    @error('city')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="postal" class="block text-gray-600 mb-1">Postal Code <span class="text-red-500" aria-hidden="true">*</span><span class="sr-only">(required)</span></label>
                    <input 
                        type="text" 
                        name="postal" 
                        id="postal" 
                        class="input-box w-full" 
                        value="{{ old('postal') }}"
                        required 
                        aria-required="true"
                        placeholder="10001">
                    @error('postal')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="phone" class="block text-gray-600 mb-1">Phone Number <span class="text-red-500" aria-hidden="true">*</span><span class="sr-only">(required)</span></label>
                    <input 
                        type="tel" 
                        name="phone" 
                        id="phone" 
                        class="input-box w-full" 
                        value="{{ old('phone') }}"
                        required 
                        aria-required="true"
                        placeholder="+1 (555) 123-4567">
                    @error('phone')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-gray-600 mb-1">Email Address <span class="text-red-500" aria-hidden="true">*</span><span class="sr-only">(required)</span></label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="input-box w-full" 
                        value="{{ old('email') }}"
                        required 
                        aria-required="true"
                        placeholder="john.doe@example.com">
                    @error('email')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </fieldset>

        <!-- Payment Method -->
        <fieldset class="mt-8">
            <legend class="text-lg font-medium mb-4">Payment Method</legend>
            <div class="space-y-4">
                <div class="flex items-center gap-6">
                    <label class="flex items-center cursor-pointer">
                        <input 
                            type="radio" 
                            name="payment_method" 
                            value="credit_card" 
                            class="mr-2 focus:ring-2 focus:ring-primary" 
                            required 
                            aria-required="true">
                        <span class="text-gray-700">Credit Card</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input 
                            type="radio" 
                            name="payment_method" 
                            value="paypal" 
                            class="mr-2 focus:ring-2 focus:ring-primary">
                        <span class="text-gray-700">PayPal</span>
                    </label>
                </div>
                @error('payment_method')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
        </fieldset>
    </form>

    <!-- Order Summary -->
    <aside class="col-span-4 border border-gray-200 p-6 rounded bg-white shadow-sm sticky top-4">
        <h4 class="text-gray-800 text-lg mb-4 font-medium uppercase">Order Summary</h4>
        
        <div class="space-y-4">
            <div class="flex justify-between border-b border-gray-200 pb-2">
                <div>
                    <h5 class="text-gray-800 font-medium">Italian Sofa</h5>
                    <p class="text-sm text-gray-600">Size: M</p>
                </div>
                <p class="text-gray-600">×2</p>
                <p class="text-gray-800 font-medium">${{ number_format(640, 2) }}</p>
            </div>
            <div class="flex justify-between border-b border-gray-200 pb-2">
                <div>
                    <h5 class="text-gray-800 font-medium">Modern Chair</h5>
                    <p class="text-sm text-gray-600">Size: L</p>
                </div>
                <p class="text-gray-600">×1</p>
                <p class="text-gray-800 font-medium">${{ number_format(120, 2) }}</p>
            </div>
        </div>

        <div class="space-y-3 mt-4 pt-4 border-t border-gray-200">
            <div class="flex justify-between text-gray-700">
                <p>Subtotal</p>
                <p>${{ number_format(760, 2) }}</p>
            </div>
            <div class="flex justify-between text-gray-700">
                <p>Shipping</p>
                <p class="text-green-600">Free</p>
            </div>
            <div class="flex justify-between text-gray-800 font-semibold text-lg pt-2 border-t border-gray-200">
                <p>Total</p>
                <p>${{ number_format(760, 2) }}</p>
            </div>
        </div>

      

        <button 
            type="submit" 
            form="checkout-form" 
            class="block w-full py-3 px-4 mt-4 text-center text-white bg-primary border border-primary rounded-md hover:bg-primary-dark focus:ring-2 focus:ring-primary focus:outline-none transition font-medium disabled:bg-gray-400 disabled:cursor-not-allowed"
            aria-label="Place your order">
            Place Order
        </button>
    </aside>
</div>
@endsection

@push('styles')
<style>
    .input-box {
        @apply w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition;
    }
    .input-box:invalid {
        @apply border-red-500;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const agreement = document.getElementById('agreement');
            if (!agreement.checked) {
                e.preventDefault();
                agreement.focus();
            }
        });
    });
</script>
@endpush