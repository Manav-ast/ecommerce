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
                            <input type="checkbox" id="{{ $category->slug }}" class="category-checkbox text-primary focus:ring-2 focus:ring-primary/20 rounded-sm cursor-pointer transition-colors"
                                value="{{ $category->id }}" data-slug="{{ $category->slug }}">
                            <label for="{{ $category->slug }}" class="text-gray-600 ml-3 cursor-pointer group-hover:text-gray-800 transition-colors flex-1">
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

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- JavaScript for Filtering (Using jQuery) -->
    <script>
        $(document).ready(function () {
            // Mobile filter toggle functionality
            $("#mobile-filter-toggle").click(function () {
                $("#filter-sidebar").toggleClass("hidden");
                let btnText = $("#filter-sidebar").hasClass("hidden") ? '<i class="fa-solid fa-filter"></i> Show Filters' : '<i class="fa-solid fa-times"></i> Hide Filters';
                $(this).html(btnText);
            });

            // Ensure sidebar is visible on desktop and hidden on mobile resize
            $(window).resize(function () {
                if ($(window).width() >= 768) { // md breakpoint
                    $("#filter-sidebar").removeClass("hidden");
                } else {
                    $("#filter-sidebar").addClass("hidden");
                }
            });

            // Auto-select category from URL query params
            let urlParams = new URLSearchParams(window.location.search);
            let selectedCategorySlug = urlParams.get("category");

            if (selectedCategorySlug) {
                $(".category-checkbox").each(function () {
                    if ($(this).data("slug") === selectedCategorySlug) {
                        $(this).prop("checked", true);
                    }
                });
            }

            // Function to fetch filtered products via AJAX
            function fetchFilteredProducts() {
                let selectedCategories = $(".category-checkbox:checked").map(function () {
                    return $(this).data("slug");
                }).get();

                let minPrice = $("#min-price").val() || 0;
                let maxPrice = $("#max-price").val() || 10000;

                $.get(`/shop/filter`, {
                    categories: selectedCategories.join(','),
                    min_price: minPrice,
                    max_price: maxPrice
                }, function (data) {
                    $("#productContainer").html(data);
                });
            }

            // Auto-apply filters if category was pre-selected
            if (selectedCategorySlug) {
                fetchFilteredProducts();
            }

            // Event listeners for filtering
            $(".category-checkbox").change(fetchFilteredProducts);
            $("#apply-filters").click(fetchFilteredProducts);
        });
    </script>
@endsection
