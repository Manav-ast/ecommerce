@extends('layouts.users.app')

@section('content')
    <div class="container grid grid-cols-12 items-start gap-6 pb-16 pt-4" role="main">
        <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form"
            class="col-span-8 border border-gray-200 p-6 rounded bg-white shadow-sm">
            @csrf

            <h3 class="text-xl font-semibold capitalize mb-6">Checkout</h3>

            <!-- Hidden input for address type, defaulting to billing -->
            <input type="hidden" name="address_type" value="billing">

            <!-- Saved Addresses Section -->
            @if (Auth::check() && Auth::user()->addresses->count() > 0)
                <div class="mb-6">
                    <h4 class="text-lg font-medium mb-3">Your Saved Addresses</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @php
                            // Get default address
                            $defaultAddress = Auth::user()->addresses->where('is_default', true)->first();

                            // Get most recent non-default address if exists
                            $recentAddress = Auth::user()
                                ->addresses->where('is_default', false)
                                ->sortByDesc('created_at')
                                ->first();
                        @endphp

                        @if ($defaultAddress)
                            <div class="border border-gray-200 rounded-md p-3 hover:border-blue-500 cursor-pointer transition-all bg-blue-50"
                                onclick="selectSavedAddress({{ json_encode($defaultAddress) }}, event)">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="font-medium text-gray-800">{{ ucfirst($defaultAddress->type) }}
                                        Address</span>
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">Default</span>
                                </div>
                                <p class="text-sm text-gray-600">{{ $defaultAddress->address_line1 }}</p>
                                @if ($defaultAddress->address_line2)
                                    <p class="text-sm text-gray-600">{{ $defaultAddress->address_line2 }}</p>
                                @endif
                                <p class="text-sm text-gray-600">{{ $defaultAddress->city }}, {{ $defaultAddress->state }}
                                    {{ $defaultAddress->postal_code }}</p>
                                <p class="text-sm text-gray-600">{{ $defaultAddress->country }}</p>
                            </div>
                        @endif

                        @if ($recentAddress)
                            <div class="border border-gray-200 rounded-md p-3 hover:border-blue-500 cursor-pointer transition-all"
                                onclick="selectSavedAddress({{ json_encode($recentAddress) }}, event)">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="font-medium text-gray-800">{{ ucfirst($recentAddress->type) }}
                                        Address</span>
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Recent</span>
                                </div>
                                <p class="text-sm text-gray-600">{{ $recentAddress->address_line1 }}</p>
                                @if ($recentAddress->address_line2)
                                    <p class="text-sm text-gray-600">{{ $recentAddress->address_line2 }}</p>
                                @endif
                                <p class="text-sm text-gray-600">{{ $recentAddress->city }}, {{ $recentAddress->state }}
                                    {{ $recentAddress->postal_code }}</p>
                                <p class="text-sm text-gray-600">{{ $recentAddress->country }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Billing Information -->
            <fieldset class="space-y-6">
                <legend class="text-lg font-medium mb-4">Billing Details</legend>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="first-name" class="block text-gray-600 mb-1">First Name <span class="text-blue-500"
                                aria-hidden="true">*</span><span class="sr-only">(required)</span></label>
                        <input type="text" name="first_name" id="first-name" class="input-box w-full"
                            value="{{ old('first_name', Auth::user()->name ?? '') }}" required aria-required="true"
                            placeholder="John">
                        @error('first_name')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="last-name" class="block text-gray-600 mb-1">Last Name <span class="text-blue-500"
                                aria-hidden="true">*</span><span class="sr-only">(required)</span></label>
                        <input type="text" name="last_name" id="last-name" class="input-box w-full"
                            value="{{ old('last_name') }}" required aria-required="true" placeholder="Doe">
                        @error('last_name')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="company" class="block text-gray-600 mb-1">Company <span
                            class="text-gray-400">(optional)</span></label>
                    <input type="text" name="company" id="company" class="input-box w-full"
                        value="{{ old('company') }}" placeholder="Your company name">
                </div>

                <div>
                    <label for="region" class="block text-gray-600 mb-1">Country/Region <span class="text-blue-500"
                            aria-hidden="true">*</span><span class="sr-only">(required)</span></label>
                    <select name="region" id="region" class="input-box w-full" required aria-required="true">
                        <option value="">Select a country</option>
                        @foreach ($countries as $code => $name)
                            <option value="{{ $code }}" {{ old('region') == $code ? 'selected' : '' }}>
                                {{ $name }}</option>
                        @endforeach
                    </select>
                    @error('region')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block text-gray-600 mb-1">Street Address <span class="text-blue-500"
                            aria-hidden="true">*</span><span class="sr-only">(required)</span></label>
                    <input type="text" name="address" id="address" class="input-box w-full"
                        value="{{ old('address') }}" required aria-required="true" placeholder="123 Main St">
                    @error('address')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="address_line2" class="block text-gray-600 mb-1">Apartment, suite, etc. <span
                            class="text-gray-400">(optional)</span></label>
                    <input type="text" name="address_line2" id="address_line2" class="input-box w-full"
                        value="{{ old('address_line2') }}" placeholder="Apartment, suite, unit, etc.">
                    @error('address_line2')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="city" class="block text-gray-600 mb-1">City <span class="text-blue-500"
                                aria-hidden="true">*</span><span class="sr-only">(required)</span></label>
                        <input type="text" name="city" id="city" class="input-box w-full"
                            value="{{ old('city') }}" required aria-required="true" placeholder="New York">
                        @error('city')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="state" class="block text-gray-600 mb-1">State/Province <span
                                class="text-gray-400">(optional)</span></label>
                        <input type="text" name="state" id="state" class="input-box w-full"
                            value="{{ old('state') }}" placeholder="NY">
                        @error('state')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="postal" class="block text-gray-600 mb-1">Postal Code <span class="text-blue-500"
                                aria-hidden="true">*</span><span class="sr-only">(required)</span></label>
                        <input type="text" name="postal" id="postal" class="input-box w-full"
                            value="{{ old('postal') }}" required aria-required="true" placeholder="10001">
                        @error('postal')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="phone" class="block text-gray-600 mb-1">Phone Number <span class="text-blue-500"
                                aria-hidden="true">*</span><span class="sr-only">(required)</span></label>
                        <input type="tel" name="phone" id="phone" class="input-box w-full"
                            value="{{ old('phone', Auth::user()->phone_no ?? '') }}" required aria-required="true"
                            placeholder="1010901080">
                        @error('phone')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-gray-600 mb-1">Email Address <span class="text-blue-500"
                                aria-hidden="true">*</span><span class="sr-only">(required)</span></label>
                        <input type="email" name="email" id="email" class="input-box w-full"
                            value="{{ old('email', Auth::user()->email ?? '') }}" required aria-required="true"
                            placeholder="john.doe@example.com">
                        @error('email')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Save as Default Address Checkbox -->
                @if (Auth::check())
                    <div class="mt-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="save_as_default" id="save_as_default"
                                class="mr-2 focus:ring-2 focus:ring-blue-500" value="1"
                                {{ old('save_as_default') ? 'checked' : '' }}>
                            <span class="text-gray-700">Save this as my default address</span>
                        </label>
                    </div>
                @endif
            </fieldset>

            <!-- Shipping Address Checkbox -->
            <div class="mt-6 mb-6">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="shipping_same_as_billing" id="shipping_same_as_billing"
                        class="mr-2 focus:ring-2 focus:ring-blue-500" value="1"
                        {{ old('shipping_same_as_billing') ? 'checked' : '' }}>
                    <span class="text-gray-700">Shipping address is same as billing address</span>
                </label>
            </div>

            <!-- Shipping Address Form -->
            <fieldset id="shipping_address_form"
                class="space-y-6 mt-6 {{ old('shipping_same_as_billing') ? 'hidden' : '' }}">
                <legend class="text-lg font-medium mb-4">Shipping Details</legend>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="shipping_address" class="block text-gray-600 mb-1">Street Address <span
                                class="text-blue-500" aria-hidden="true">*</span><span
                                class="sr-only">(required)</span></label>
                        <input type="text" name="shipping_address" id="shipping_address" class="input-box w-full"
                            value="{{ old('shipping_address') }}" placeholder="123 Main St">
                        @error('shipping_address')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="shipping_address_line2" class="block text-gray-600 mb-1">Apartment, suite, etc. <span
                                class="text-gray-400">(optional)</span></label>
                        <input type="text" name="shipping_address_line2" id="shipping_address_line2"
                            class="input-box w-full" value="{{ old('shipping_address_line2') }}"
                            placeholder="Apartment, suite, unit, etc.">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="shipping_city" class="block text-gray-600 mb-1">City <span class="text-blue-500"
                                aria-hidden="true">*</span><span class="sr-only">(required)</span></label>
                        <input type="text" name="shipping_city" id="shipping_city" class="input-box w-full"
                            value="{{ old('shipping_city') }}" placeholder="New York">
                        @error('shipping_city')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="shipping_state" class="block text-gray-600 mb-1">State/Province <span
                                class="text-gray-400">(optional)</span></label>
                        <input type="text" name="shipping_state" id="shipping_state" class="input-box w-full"
                            value="{{ old('shipping_state') }}" placeholder="NY">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="shipping_postal" class="block text-gray-600 mb-1">Postal Code <span
                                class="text-blue-500" aria-hidden="true">*</span><span
                                class="sr-only">(required)</span></label>
                        <input type="text" name="shipping_postal" id="shipping_postal" class="input-box w-full"
                            value="{{ old('shipping_postal') }}" placeholder="10001">
                        @error('shipping_postal')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="shipping_region" class="block text-gray-600 mb-1">Country/Region <span
                                class="text-blue-500" aria-hidden="true">*</span><span
                                class="sr-only">(required)</span></label>
                        <select name="shipping_region" id="shipping_region" class="input-box w-full">
                            <option value="">Select a country</option>
                            @foreach ($countries as $code => $name)
                                <option value="{{ $code }}"
                                    {{ old('shipping_region') == $code ? 'selected' : '' }}>
                                    {{ $name }}</option>
                            @endforeach
                        </select>
                        @error('shipping_region')
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
                            <input type="radio" name="payment_method" value="credit_card"
                                class="mr-2 focus:ring-2 focus:ring-blue-500"
                                {{ old('payment_method') == 'credit_card' ? 'checked' : '' }} required
                                aria-required="true">
                            <span class="text-gray-700">Credit Card</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="payment_method" value="paypal"
                                class="mr-2 focus:ring-2 focus:ring-blue-500"
                                {{ old('payment_method') == 'paypal' ? 'checked' : '' }}>
                            <span class="text-gray-700">PayPal</span>
                        </label>
                    </div>
                    @error('payment_method')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </fieldset>

            <!-- Terms and Conditions -->
            <div class="mt-8">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="agreement" id="agreement" class="mr-2 focus:ring-2 focus:ring-blue-500"
                        required aria-required="true">
                    <span class="text-gray-700">I agree to the <a href="#"
                            class="text-blue-500 hover:underline">Terms and Conditions</a> and <a href="#"
                            class="text-blue-500 hover:underline">Privacy Policy</a></span>
                </label>
                @error('agreement')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
        </form>

        <!-- Order Summary -->
        <aside class="col-span-4 border border-gray-200 p-6 rounded bg-white shadow-sm sticky top-4">
            <h4 class="text-gray-800 text-lg mb-4 font-medium uppercase">Order Summary</h4>

            <div class="space-y-4">
                @foreach ($cart as $id => $item)
                    <div class="flex justify-between border-b border-gray-200 pb-2">
                        <div>
                            <h5 class="text-gray-800 font-medium">{{ $item['name'] }}</h5>
                        </div>
                        <p class="text-gray-600">X {{ $item['quantity'] }}</p>
                        <p class="text-gray-800 font-medium">${{ number_format($item['price'] * $item['quantity'], 2) }}
                        </p>
                    </div>
                @endforeach
            </div>

            <div class="space-y-3 mt-4 pt-4 border-t border-gray-200">
                <div class="flex justify-between text-gray-700">
                    <p>Subtotal</p>
                    <p>${{ number_format($cartTotal, 2) }}</p>
                </div>
                <div class="flex justify-between text-gray-700">
                    <p>Shipping</p>
                    <p class="text-green-600">Free</p>
                </div>
                <div class="flex justify-between text-gray-800 font-semibold text-lg pt-2 border-t border-gray-200">
                    <p>Total</p>
                    <p>${{ number_format($cartTotal, 2) }}</p>
                </div>
            </div>

            <button type="submit" form="checkout-form"
                class="block w-full py-3 px-4 mt-4 text-center text-white bg-blue-500 border border-blue-500 rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:outline-none transition font-medium disabled:bg-gray-400 disabled:cursor-not-allowed"
                aria-label="Place your order">
                Place Order
            </button>
        </aside>
    </div>
@endsection

@push('styles')
    <style>
        .input-box {
            @apply w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition;
        }

        .input-box:invalid {
            @apply border-red-500;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('checkout-form');
            const shippingSameAsBilling = document.getElementById('shipping_same_as_billing');
            const shippingAddressForm = document.getElementById('shipping_address_form');

            // Function to toggle shipping address form visibility
            function toggleShippingForm() {
                if (shippingSameAsBilling.checked) {
                    shippingAddressForm.classList.add('hidden');
                } else {
                    shippingAddressForm.classList.remove('hidden');
                }
            }

            // Initial toggle based on checkbox state
            toggleShippingForm();

            // Add event listener for checkbox changes
            shippingSameAsBilling.addEventListener('change', toggleShippingForm);

            // Function to fill form with selected saved address
            window.selectSavedAddress = function(address, event) {
                // Fill billing address fields
                document.getElementById('address').value = address.address_line1;
                document.getElementById('address_line2').value = address.address_line2 || '';
                document.getElementById('city').value = address.city;
                document.getElementById('state').value = address.state || '';
                document.getElementById('postal').value = address.postal_code;
                document.getElementById('region').value = address.country;

                // Highlight the selected address
                const addressCards = document.querySelectorAll('.grid .border');
                addressCards.forEach(card => {
                    card.classList.remove('bg-blue-50', 'border-blue-500');
                });
                event.currentTarget.classList.add('bg-blue-50', 'border-blue-500');

                // Optionally auto-fill shipping address if it's the same
                if (shippingSameAsBilling.checked) {
                    // No need to fill shipping fields as they will use the billing address
                } else {
                    // Only if the address type is shipping, fill the shipping fields
                    if (address.type === 'shipping') {
                        document.getElementById('shipping_address').value = address.address_line1;
                        document.getElementById('shipping_address_line2').value = address.address_line2 || '';
                        document.getElementById('shipping_city').value = address.city;
                        document.getElementById('shipping_state').value = address.state || '';
                        document.getElementById('shipping_postal').value = address.postal_code;
                        document.getElementById('shipping_region').value = address.country;
                    }
                }
            };

            form.addEventListener('submit', function(e) {
                const agreement = document.getElementById('agreement');
                if (!agreement.checked) {
                    e.preventDefault();
                    agreement.focus();

                    // Show error message
                    const errorElement = document.createElement('span');
                    errorElement.classList.add('text-red-500', 'text-sm', 'mt-1', 'agreement-error');
                    errorElement.textContent = 'You must agree to the Terms and Conditions';

                    // Remove existing error message if any
                    const existingError = document.querySelector('.agreement-error');
                    if (existingError) {
                        existingError.remove();
                    }

                    // Add error message after the label
                    agreement.parentElement.parentElement.appendChild(errorElement);
                }
            });
        });
    </script>
@endpush
