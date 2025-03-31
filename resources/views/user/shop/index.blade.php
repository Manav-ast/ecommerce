@extends('layouts.users.app')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Mobile Filter Toggle Button -->
        <div class="md:hidden mb-4">
            <button id="mobile-filter-toggle"
                class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2">
                <i class="fa-solid fa-filter"></i> Show Filters
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-[280px,1fr] gap-8">
            <!-- Sidebar -->
            <aside id="filter-sidebar" class="bg-white p-6 rounded-lg shadow-md md:block hidden">
                <!-- Categories -->
                <h3 class="text-lg font-semibold text-gray-800 mb-5 uppercase tracking-wide">Categories</h3>
                <div class="space-y-3">
                    @foreach ($categories as $category)
                        <div class="flex items-center group">
                            <input type="checkbox" id="{{ $category->slug }}"
                                class="category-checkbox text-primary focus:ring-2 focus:ring-primary/20 rounded-sm cursor-pointer transition-colors"
                                value="{{ $category->id }}" data-slug="{{ $category->slug }}">
                            <label for="{{ $category->slug }}"
                                class="text-gray-600 ml-3 cursor-pointer group-hover:text-gray-800 transition-colors flex-1">
                                {{ $category->name }}
                            </label>
                        </div>
                    @endforeach

                </div>

                <!-- Price Filter -->
                <h3 class="text-lg font-semibold text-gray-800 mt-8 mb-5 uppercase tracking-wide">Price Range</h3>
                <div class="grid grid-cols-2 gap-3">
                    <input type="number" name="min" id="min-price"
                        class="w-full border-gray-300 focus:border-primary rounded-full focus:ring-2 focus:ring-primary/20 px-3 py-2 shadow-sm placeholder-gray-400 text-sm"
                        placeholder="Min" min="0" step="0.01">
                    <input type="number" name="max" id="max-price"
                        class="w-full border-gray-300 focus:border-primary rounded-full focus:ring-2 focus:ring-primary/20 px-3 py-2 shadow-sm placeholder-gray-400 text-sm"
                        placeholder="Max" min="0" step="0.01">
                </div>
                <button id="apply-filters"
                    class="bg-blue-500 border border-blue-500 text-white px-8 py-3 font-medium rounded-full uppercase flex items-center justify-center gap-2 hover:bg-transparent hover:text-blue-700 transition-all duration-300 w-full mt-2"
                    type="button">
                    Apply Filters
                </button>
            </aside>

            <!-- Products Section -->
            <section class="pb-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-2">
                    <h2 class="text-2xl sm:text-3xl font-semibold text-gray-800">Shop Products</h2>
                    <span class="text-gray-600 text-sm sm:text-base">{{ count($products) }} items</span>
                </div>

                <!-- Product Grid -->
                <div id="productContainer"
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($products as $product)
                        <x-users.product-card :product="$product" />
                    @endforeach
                </div>
            </section>
        </div>
        <div class="mt-8 px-4">
            {{ $products->links() }}
        </div>
    </div>

    <!-- JavaScript for Filtering -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Mobile filter toggle functionality
            const mobileFilterToggle = document.getElementById("mobile-filter-toggle");
            const filterSidebar = document.getElementById("filter-sidebar");

            if (mobileFilterToggle && filterSidebar) {
                mobileFilterToggle.addEventListener("click", function() {
                    filterSidebar.classList.toggle("hidden");

                    // Update button text based on visibility
                    if (filterSidebar.classList.contains("hidden")) {
                        mobileFilterToggle.innerHTML = '<i class="fa-solid fa-filter"></i> Show Filters';
                    } else {
                        mobileFilterToggle.innerHTML = '<i class="fa-solid fa-times"></i> Hide Filters';
                    }
                });
            }

            // Close filters when window is resized to desktop view
            window.addEventListener("resize", function() {
                if (window.innerWidth >= 768) { // md breakpoint
                    filterSidebar.classList.remove("hidden");
                } else {
                    filterSidebar.classList.add("hidden");
                }
            });
            const checkboxes = document.querySelectorAll(".category-checkbox");
            const minPriceInput = document.getElementById("min-price");
            const maxPriceInput = document.getElementById("max-price");
            const applyFiltersButton = document.getElementById("apply-filters");

            // Function to get URL query parameters
            function getQueryParam(param) {
                let urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(param);
            }

            // Auto-select category if present in URL
            let selectedCategorySlug = getQueryParam("category");

            if (selectedCategorySlug) {
                checkboxes.forEach(checkbox => {
                    if (checkbox.dataset.slug === selectedCategorySlug) {
                        checkbox.checked = true;
                    }
                });
            }

            function fetchFilteredProducts() {
                let selectedCategories = [];
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        selectedCategories.push(checkbox.dataset.slug);
                    }
                });

                let minPrice = minPriceInput.value || 0;
                let maxPrice = maxPriceInput.value || 10000;

                fetch(
                        `/shop/filter?categories=${selectedCategories.join(',')}&min_price=${minPrice}&max_price=${maxPrice}`
                    )
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById("productContainer").innerHTML = data;
                    });
            }

            // Apply filtering on page load if category was selected
            if (selectedCategorySlug) {
                fetchFilteredProducts();
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", fetchFilteredProducts);
            });

            applyFiltersButton.addEventListener("click", fetchFilteredProducts);
        });
    </script>
@endsection
