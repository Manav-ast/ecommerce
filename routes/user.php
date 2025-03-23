<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;



Route::middleware("guest:user")->group(function () {
    Route::get("login", [LoginController::class, "index"])->name("user.login");
    Route::post("login", [LoginController::class, "authenticate"])->name("user.authenticate");
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('user.register');
    Route::post('/register', [RegisterController::class, 'register']);
});


Route::middleware("auth:user")->group(function () {
    Route::get("logout", [LoginController::class, "logout"])->name("user.logout");

    // Homepage Route
    Route::get("/", [HomepageController::class, "index"])->name("home");

    // Navbar (or Global Categories) Route (Change Path)
    Route::get("/categories", [CategoryController::class, "index"])->name("categories.list");

    // Shop & Products Routes
    Route::get("/shop", [ProductController::class, "index"])->name("shop.index");
    Route::get('/shop/filter', [ProductController::class, 'filter'])->name('shop.filter');
    Route::get("/products/{slug}", [ProductController::class, "show"])->name("shop.show");

    // Cart Routes
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
});