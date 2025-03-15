<x-admin-layout>
    <div class="p-10">
        <!-- Page Title -->
        <h2 class="text-2xl font-bold mb-4">Products</h2>
        
        <!-- Search and Filter Section -->
        <div class="flex justify-end bg-white p-4 rounded-lg shadow-md">
            {{-- <input type="text" placeholder="Search Products" class="border p-2 rounded-md w-1/3"> --}}
            <button class="bg-green-600 text-white px-4 py-2 rounded-md">Add Product</button>
        </div>
        
        <!-- Products Table -->
        <div class="mt-6 bg-white shadow-md rounded-lg overflow-hidden">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-sm font-semibold border-b border-gray-300">
                        <th class="p-3 text-left">Image</th>
                        <th class="p-3 text-left">Product Name</th>
                        <th class="p-3 text-left">Category</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Price</th>
                        <th class="p-3 text-left">Created At</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @foreach($products as $product)
                    <tr>
                        <td><img src="{{ Vite::asset('resources/images/products/product-img-1.jpg') }}" class="w-16 h-16 rounded-md"></td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category }}</td>
                        <td>{{ $product->price }}</td>
                        <td><span class="px-2 py-1 text-white {{ $product->status == 'Active' ? 'bg-green-500' : 'bg-red-500' }} rounded">{{ $product->status }}</span></td>
                        <td>{{ $product->added_on }}</td>
                    </tr>
                @endforeach

                    
                    @if(count($products)==0)
                        <tr>
                            <td colspan="6" class="p-3 text-center text-gray-500">No products available</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
