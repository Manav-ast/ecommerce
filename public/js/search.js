document.addEventListener('DOMContentLoaded', function () {
    // Common search functionality for both desktop and mobile
    function setupSearch(inputSelector, resultsSelector) {
        const searchInput = document.querySelector(inputSelector);
        const searchResults = document.querySelector(resultsSelector);
        let debounceTimer;

        if (!searchInput || !searchResults) return;

        // Create search results container if it doesn't exist
        if (!document.querySelector(resultsSelector)) {
            const resultsDiv = document.createElement('div');
            resultsDiv.id = resultsSelector.substring(1);
            resultsDiv.className = 'absolute w-full bg-white mt-1 rounded-lg shadow-lg overflow-hidden z-50';

            // Add styles for search results list
            const style = document.createElement('style');
            style.textContent = `
                .search-results-list {
                    list-style-type: none;
                    padding: 0;
                    margin: 0;
                }
                .search-result-item {
                    width: 100%;
                }
                .search-results-container {
                    position: absolute;
                    width: 100%;
                    top: 100%;
                    left: 0;
                    z-index: 50;
                }
            `;
            document.head.appendChild(style);

            // Create a container for better positioning
            const containerDiv = document.createElement('div');
            containerDiv.className = 'search-results-container';
            containerDiv.appendChild(resultsDiv);

            // Position the container relative to the search input
            const inputRect = searchInput.getBoundingClientRect();
            containerDiv.style.width = inputRect.width + 'px';

            // Append the container to the parent node
            const parentNode = searchInput.parentNode;
            parentNode.style.position = 'relative';
            parentNode.appendChild(containerDiv);
        }

        // Function to perform the search with debouncing
        searchInput.addEventListener('input', function () {
            performSearch(this);
        });

        // Also trigger search on keyup for better responsiveness
        searchInput.addEventListener('keyup', function (e) {
            // If Enter key is pressed, prevent default form submission
            if (e.key === 'Enter') {
                e.preventDefault();
                const query = this.value.trim();
                if (query !== '') {
                    window.location.href = `/search?search=${encodeURIComponent(query)}`;
                }
                return;
            }
            performSearch(this);
        });

        // Check if there's already a value in the search input on page load
        if (searchInput.value.trim() !== '') {
            performSearch(searchInput);
        }

        // Function to perform the actual search
        function performSearch(inputElement) {
            const query = inputElement.value.trim();

            // Clear any existing timeout
            clearTimeout(debounceTimer);

            // Hide results if query is empty
            if (query === '') {
                searchResults.innerHTML = '';
                searchResults.classList.add('hidden');
                return;
            }

            // Set a new timeout for debouncing (300ms)
            debounceTimer = setTimeout(function () {
                // Show loading indicator
                searchResults.innerHTML = '<div class="p-4 text-center text-gray-500">Searching...</div>';
                searchResults.classList.remove('hidden');

                // Make AJAX request to search endpoint
                fetch(`/search/products?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        let resultsHtml = '';

                        // Display categories if available
                        if (data.categories && data.categories.length > 0) {
                            resultsHtml += '<div class="p-2 text-xs font-semibold text-gray-500 bg-gray-50">Categories</div>';
                            resultsHtml += '<ul class="search-results-list">';

                            // Build categories HTML
                            data.categories.forEach(function (category) {
                                resultsHtml += `
                                    <li class="search-result-item">
                                        <a href="/shop?category=${category.slug}" class="block p-3 hover:bg-gray-50 transition duration-200 border-b border-gray-100">
                                            <div class="flex items-center">
                                                <div class="flex-1">
                                                    <p class="text-sm font-medium text-gray-900 truncate">${category.name}</p>
                                                    <p class="text-xs text-gray-500">Category</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                `;
                            });

                            // Close the categories list
                            resultsHtml += '</ul>';
                        }

                        // Display products if available
                        if (data.products && data.products.length > 0) {
                            resultsHtml += '<div class="p-2 text-xs font-semibold text-gray-500 bg-gray-50">Products</div>';
                            resultsHtml += '<ul class="search-results-list">';

                            // Build results HTML
                            data.products.forEach(function (product) {
                                resultsHtml += `
                                    <li class="search-result-item">
                                        <a href="/products/${product.slug}" class="block p-3 hover:bg-gray-50 transition duration-200 border-b border-gray-100 last:border-0">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex-shrink-0 w-10 h-10 bg-gray-100 rounded overflow-hidden">
                                                    <img src="/storage/${product.image}" alt="${product.name}" class="w-full h-full object-cover">
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-medium text-gray-900 truncate">${product.name}</p>
                                                    <p class="text-xs text-gray-500">${product.categories && product.categories.length > 0 ? product.categories[0].name : 'Uncategorized'}</p>
                                                    <p class="text-sm text-green-600">$${product.price}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                `;
                            });

                            // Close the products list
                            resultsHtml += '</ul>';

                            // Add view all results link
                            resultsHtml += `
                                <a href="/search?search=${encodeURIComponent(query)}" class="block p-3 text-center text-sm text-green-600 hover:text-green-700 font-medium hover:bg-gray-50 transition duration-200">
                                    View all results
                                </a>
                            `;

                            searchResults.innerHTML = resultsHtml;
                            searchResults.classList.remove('hidden');
                        } else if (data.categories && data.categories.length > 0) {
                            // If we only have categories and no products, we've already built the HTML
                            searchResults.innerHTML = resultsHtml;
                            searchResults.classList.remove('hidden');
                        } else {
                            // No products or categories found
                            searchResults.innerHTML = '<ul class="search-results-list"><li class="search-result-item"><div class="p-4 text-center text-gray-500">No results found</div></li></ul>';
                            searchResults.classList.remove('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        searchResults.innerHTML = '<ul class="search-results-list"><li class="search-result-item"><div class="p-4 text-center text-red-500">Error searching products</div></li></ul>';
                        searchResults.classList.remove('hidden');
                    });
            }, 300); // 300ms debounce delay
        }

        // Close search results when clicking outside
        document.addEventListener('click', function (event) {
            if (!event.target.closest(inputSelector) && !event.target.closest(resultsSelector)) {
                searchResults.classList.add('hidden');
            }
        });

        // Handle form submission
        const form = searchInput.closest('form');
        if (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                const query = searchInput.value.trim();
                if (query !== '') {
                    window.location.href = `/search?search=${encodeURIComponent(query)}`;
                }
            });
        }
    }
    // Setup search for desktop and mobile
    setupSearch('#search', '#search-results');
});