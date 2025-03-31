/**
 * Mobile Menu Functionality
 */
document.addEventListener('DOMContentLoaded', function () {
    // Get DOM elements
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const closeMobileMenu = document.getElementById('close-mobile-menu');

    // Toggle mobile menu when hamburger icon is clicked
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function () {
            mobileMenu.classList.remove('hidden');
            document.body.classList.add('overflow-hidden'); // Prevent scrolling when menu is open
        });
    }

    // Close mobile menu when close button is clicked
    if (closeMobileMenu) {
        closeMobileMenu.addEventListener('click', function () {
            mobileMenu.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
    }

    // Close mobile menu when clicking outside the menu
    if (mobileMenu) {
        mobileMenu.addEventListener('click', function (event) {
            // Close only if clicking the overlay (not the menu itself)
            if (event.target === mobileMenu) {
                mobileMenu.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
    }

    // Handle window resize (close mobile menu on larger screens)
    window.addEventListener('resize', function () {
        if (window.innerWidth >= 768 && mobileMenu && !mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    });
});