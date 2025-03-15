<x-layout>
    <x-slider />

    <!-- Featured Categories Section -->
    <section class="py-12 bg-gradient-to-b from-white to-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-col items-center mb-10 text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Featured Categories</h2>
                <div class="w-20 h-1 bg-orange-500 rounded-full"></div>
            </div>
            <x-featured-catagory/>
        </div>
    </section>

    <!-- Promotional Banners Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Fruits & Vegetables Banner -->
                <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-r from-green-50 to-green-100 shadow-lg transition-all duration-300 hover:shadow-2xl">
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110" 
                         style="background-image: url({{ Vite::asset('resources/images/grocery-banner.png') }});"></div>
                    <div class="relative z-10 p-10 backdrop-blur-sm bg-white/30">
                        <span class="inline-block px-4 py-1 bg-green-500 text-white text-sm font-semibold rounded-full mb-4">Fresh Daily</span>
                        <h2 class="text-4xl font-bold text-gray-900 mb-4">Fruits & Vegetables</h2>
                        <p class="text-lg text-gray-800 mb-6">Get Up to <span class="font-bold text-green-600">30%</span> Off</p>
                        <a href="#" class="inline-flex items-center px-8 py-3 bg-gray-900 text-white rounded-full hover:bg-gray-800 transition-colors duration-300 shadow-lg hover:shadow-gray-300/50">
                            Shop Now
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Bakery Banner -->
                <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-r from-orange-50 to-orange-100 shadow-lg transition-all duration-300 hover:shadow-2xl">
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110" 
                         style="background-image: url({{ Vite::asset('resources/images/grocery-banner-2.jpg') }});"></div>
                    <div class="relative z-10 p-10 backdrop-blur-sm bg-white/30">
                        <span class="inline-block px-4 py-1 bg-orange-500 text-white text-sm font-semibold rounded-full mb-4">Fresh Baked</span>
                        <h2 class="text-4xl font-bold text-gray-900 mb-4">Freshly Baked Buns</h2>
                        <p class="text-lg text-gray-800 mb-6">Get Up to <span class="font-bold text-orange-600">25%</span> Off</p>
                        <a href="#" class="inline-flex items-center px-8 py-3 bg-gray-900 text-white rounded-full hover:bg-gray-800 transition-colors duration-300 shadow-lg hover:shadow-gray-300/50">
                            Shop Now
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-col items-center mb-10 text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Featured Products</h2>
                <div class="w-20 h-1 bg-orange-500 rounded-full"></div>
            </div>
            <x-product-card/>
        </div>
    </section>

    <!-- Features Grid Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Quick Delivery Feature -->
                <div class="group p-8 rounded-2xl bg-gradient-to-br from-orange-50 to-orange-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 flex items-center justify-center bg-orange-500 rounded-full mb-6 group-hover:scale-110 transition-transform duration-300">
                            <img src="{{ Vite::asset('resources/images/clock.svg') }}" alt="Quick Delivery" class="w-8 h-8 text-white">
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">10 Minute Delivery</h3>
                        <p class="text-gray-600">Get your order delivered to your doorstep at the earliest from FreshCart pickup stores near you.</p>
                    </div>
                </div>

                <!-- Best Prices Feature -->
                <div class="group p-8 rounded-2xl bg-gradient-to-br from-orange-50 to-orange-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 flex items-center justify-center bg-orange-500 rounded-full mb-6 group-hover:scale-110 transition-transform duration-300">
                            <img src="{{ Vite::asset('resources/images/gift.svg') }}" alt="Best Prices" class="w-8 h-8 text-white">
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Best Prices & Offers</h3>
                        <p class="text-gray-600">Cheaper prices than your local supermarket, great cashback offers to top it off.</p>
                    </div>
                </div>

                <!-- Wide Assortment Feature -->
                <div class="group p-8 rounded-2xl bg-gradient-to-br from-orange-50 to-orange-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 flex items-center justify-center bg-orange-500 rounded-full mb-6 group-hover:scale-110 transition-transform duration-300">
                            <img src="{{ Vite::asset('resources/images/package.svg') }}" alt="Wide Assortment" class="w-8 h-8 text-white">
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Wide Assortment</h3>
                        <p class="text-gray-600">Choose from 5000+ products across food, personal care, household & other categories.</p>
                    </div>
                </div>

                <!-- Easy Returns Feature -->
                <div class="group p-8 rounded-2xl bg-gradient-to-br from-orange-50 to-orange-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 flex items-center justify-center bg-orange-500 rounded-full mb-6 group-hover:scale-110 transition-transform duration-300">
                            <img src="{{ Vite::asset('resources/images/package.svg') }}" alt="Easy Returns" class="w-8 h-8 text-white">
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Easy Returns</h3>
                        <p class="text-gray-600">Not satisfied with a product? Return it at the doorstep & get a refund within hours.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
