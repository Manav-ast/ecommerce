@foreach ($products as $product)
    <x-users.product-card :product="$product" />
@endforeach

@if ($products->isEmpty())
    <p class="text-center text-gray-500">No products found for the selected filters.</p>
@endif
