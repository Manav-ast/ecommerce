<!-- Search Component -->
<div x-data="{
    search: '',
    results: [],
    showResults: false,
    isLoading: false,

    async fetchResults() {
        if (this.search.length < 2) {
            this.results = [];
            this.showResults = false;
            return;
        }

        this.isLoading = true;
        try {
            const response = await fetch(`/api/search?q=${encodeURIComponent(this.search)}`);
            const data = await response.json();
            this.results = data;
            this.showResults = true;
        } catch (error) {
            console.error('Search error:', error);
            this.results = [];
        }
        this.isLoading = false;
    }
}" class="relative w-full max-w-xl">
    <div class="relative">
        <input x-model="search" @input.debounce.300ms="fetchResults()" @click.away="showResults = false"
            @focus="if (search.length >= 2) showResults = true" type="text"
            placeholder="Search products or categories..."
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">

        <!-- Loading indicator -->
        <div x-show="isLoading" class="absolute right-3 top-2.5">
            <svg class="animate-spin h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        </div>
    </div>

    <!-- Search Results Dropdown -->
    <div x-show="showResults && results.length > 0" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="absolute z-50 w-full mt-2 bg-white rounded-lg shadow-lg max-h-96 overflow-y-auto">
        <div class="py-2">
            <!-- Categories Section -->
            <template x-if="results.categories && results.categories.length > 0">
                <div>
                    <h3 class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-50">Categories</h3>
                    <template x-for="category in results.categories" :key="category.id">
                        <a :href="'/category/' + category.slug"
                            class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors duration-150">
                            <img :src="category.image" :alt="category.name" class="w-10 h-10 object-cover rounded">
                            <span class="ml-3 text-sm text-gray-700" x-text="category.name"></span>
                        </a>
                    </template>
                </div>
            </template>

            <!-- Products Section -->
            <template x-if="results.products && results.products.length > 0">
                <div>
                    <h3 class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-50">Products</h3>
                    <template x-for="product in results.products" :key="product.id">
                        <a :href="'/product/' + product.slug"
                            class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors duration-150">
                            <img :src="product.image" :alt="product.name" class="w-12 h-12 object-cover rounded">
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900" x-text="product.name"></p>
                                <p class="text-sm text-gray-500" x-text="'$' + product.price"></p>
                            </div>
                        </a>
                    </template>
                </div>
            </template>
        </div>
    </div>

    <!-- No Results Message -->
    <div x-show="showResults && search.length >= 2 && results.length === 0 && !isLoading"
        class="absolute z-50 w-full mt-2 bg-white rounded-lg shadow-lg p-4 text-center text-gray-500">
        No results found for your search.
    </div>
</div>
