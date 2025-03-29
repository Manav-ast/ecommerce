<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\DuplicateCheckController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\SearchController;

// Search routes

// Shop & Products Routes - Public access
Route::get("/shop", [ProductController::class, "index"])->name("shop.index");
Route::get('/shop/filter', [ProductController::class, 'filter'])->name('shop.filter');
Route::get("/products/{slug}", [ProductController::class, "show"])->name("shop.show");

// Guest routes (accessible only when not logged in)
Route::middleware("guest:user")->group(function () {
    Route::get("/login", [LoginController::class, "index"])->name("user.login");
    Route::post("/login", [LoginController::class, "authenticate"])->name("user.authenticate");
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('user.register');
    Route::post('/register', [RegisterController::class, 'register'])->name('user.register.submit');

    Route::post('/check-email', [DuplicateCheckController::class, 'checkEmail']);
    Route::post('/check-phone', [DuplicateCheckController::class, 'checkPhone']);
});

// Authenticated routes (accessible only when logged in)
Route::middleware("auth:user")->group(function () {

    Route::get("logout", [LoginController::class, "logout"])->name("user.logout");

    // Homepage Route
    Route::get("/", [HomepageController::class, "index"])->name("home");

    // User Profile Routes
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile.dashboard');
    Route::get('/profile/orders', [UserProfileController::class, 'orders'])->name('profile.orders');
    Route::get('/profile/orders/{id}/details', [UserProfileController::class, 'orderDetails'])->name('profile.order.details');

    // Cart Routes
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Search Routes
    Route::get('/search', [SearchController::class, 'searchPage']);
    Route::get('/search/products', [SearchController::class, 'search']);

    // Other Routes - Catch-all route should be last
    Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');
});

Route::middleware(['auth:user'])->group(function () {
    Route::get('/orders/{order}/invoice/download', [UserProfileController::class, 'downloadInvoice'])
        ->name('user.invoice.download');
});
