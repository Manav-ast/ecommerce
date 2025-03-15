@php
$products = [
    [
        'name' => "Haldiram's Sev Bhujia",
        'category' => 'Snack & Munchies',
        'price' => 18,
        'image' => Vite::asset('resources/images/products/product-img-1.jpg'), // Change to your actual image path
        'discount' => 'Sale',
    ],
    [
        'name' => "Haldiram's Sev Bhujia",
        'category' => 'Snack & Munchies',
        'price' => 18,
        'image' => Vite::asset('resources/images/products/product-img-1.jpg'), // Change to your actual image path
        'discount' => 'Sale',
    ],
    [
        'name' => "Haldiram's Sev Bhujia",
        'category' => 'Snack & Munchies',
        'price' => 18,
        'image' => Vite::asset('resources/images/products/product-img-1.jpg'), // Change to your actual image path
        'discount' => 'Sale',
    ],
    [
        'name' => "Haldiram's Sev Bhujia",
        'category' => 'Snack & Munchies',
        'price' => 18,
        'image' => Vite::asset('resources/images/products/product-img-1.jpg'), // Change to your actual image path
        'discount' => 'Sale',
    ],[
        'name' => "Haldiram's Sev Bhujia",
        'category' => 'Snack & Munchies',
        'price' => 18,
        'image' => Vite::asset('resources/images/products/product-img-1.jpg'), // Change to your actual image path
        'discount' => 'Sale',
    ], [
        'name' => "Haldiram's Sev Bhujia",
        'category' => 'Snack & Munchies',
        'price' => 18,
        'image' => Vite::asset('resources/images/products/product-img-1.jpg'), // Change to your actual image path
        'discount' => 'Sale',
    ], [
        'name' => "Haldiram's Sev Bhujia",
        'category' => 'Snack & Munchies',
        'price' => 18,
        'image' => Vite::asset('resources/images/products/product-img-1.jpg'), // Change to your actual image path
        'discount' => 'Sale',
    ], 
    // Add more products if needed
];
@endphp

<section class="bg-white py-2 antialiased">
    <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($products as $product)
                <div class="relative rounded-xl border-gray-100 bg-white p-6 shadow-sm border hover:border-orange-400 hover:shadow-xl transition-all duration-300">

                    <!-- Product Image -->
                    <div class="h-56 w-full flex justify-center items-center">
                        <a href="#">
                            <img class="h-full object-contain hover:scale-110 transition-all duration-300" src="{{ $product['image'] }}" alt="{{ $product['name'] }}" />
                        </a>
                    </div>

                    <!-- Product Details -->
                    <div class="pt-4">
                        <p class="text-sm text-gray-500">{{ $product['category'] }}</p>
                        <a href="#" class="text-lg font-semibold leading-tight text-gray-900 hover:underline">{{ $product['name'] }}</a>

                        <!-- Pricing & Add Button -->
                        <div class="mt-4 flex items-center justify-between">
                            <p class="text-xl font-bold text-gray-900">${{ $product['price'] }}</p>
                            <button type="button" class="inline-flex items-center rounded-lg bg-green-600 text-white px-5 py-2.5 text-sm font-medium  hover:bg-primary-800 focus:outline-none focus:ring-4  focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                <svg class="-ms-2 me-2 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                                </svg>
                                Add to cart
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
