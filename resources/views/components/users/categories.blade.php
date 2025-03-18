@props(['categories'])

<div class="container mx-auto px-4">
    <h2 class="text-3xl mt-8 font-bold text-gray-800 uppercase mb-8 text-center">Shop by Category</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 place-items-center">
        @foreach ($categories as $category)
            <div
                class="relative rounded-lg overflow-hidden group shadow-md hover:shadow-lg transition duration-300 w-full max-w-[500px] h-64">
                
                <!-- Category Image (Uniform Size) -->
                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                    class="w-full h-full object-cover aspect-[4/3] transition-transform duration-300 group-hover:scale-105">

                <!-- Overlay Effect (Hidden Initially) -->
                <div
                    class="absolute inset-0 bg-gradient-to-b from-black/40 to-black/70 opacity-0 group-hover:opacity-100 transition-all duration-300 ease-in-out">
                </div>

                <!-- Category Name (Hidden Initially, Shows on Hover) -->
                <a href="{{ url('/category/' . $category->slug) }}"
                    class="absolute inset-0 flex items-center justify-center text-lg font-semibold text-white uppercase tracking-wide opacity-0 group-hover:opacity-100 transition-all duration-300 ease-in-out">
                    {{ $category->name }}
                </a>
            </div>
        @endforeach
    </div>
</div>
