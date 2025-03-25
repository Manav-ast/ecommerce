@props(['products'])

<div class="container mx-auto px-4">
    <h2 class="text-3xl mt-8 font-bold text-gray-800 uppercase mb-8 text-center">Latest Product</h2>

    <div id="productContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($products as $product)
            <x-users.product-card :product="$product" />
        @endforeach
    </div>
</div>
