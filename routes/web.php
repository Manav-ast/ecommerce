<?php

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminRoleController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AdminLoginController;
// use App\Http\Controllers\Auth\LoginController;
// use App\Http\Controllers\Auth\RegisterController;
// use App\Http\Controllers\HomepageController;
// use App\Http\Controllers\CategoryController;
// use App\Http\Controllers\ProductController;
// use App\Http\Controllers\CartController;
// use App\Http\Controllers\CheckoutController;
use App\Models\Admin;
use Illuminate\Support\Facades\Route;


//User
// Route::middleware("guest:user")->group(function () {
//     Route::get("login", [LoginController::class, "index"])->name("user.login");
//     Route::post("login", [LoginController::class, "authenticate"])->name("user.authenticate");
//     Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('user.register');
//     Route::post('/register', [RegisterController::class, 'register']);
// });

// Route::middleware("auth:user")->group(function () {
//     Route::get("logout", [LoginController::class, "logout"])->name("user.logout");

//     // Homepage Route
//     Route::get("/", [HomepageController::class, "index"])->name("home");

//     // Navbar (or Global Categories) Route (Change Path)
//     Route::get("/categories", [CategoryController::class, "index"])->name("categories.list");

//     // Shop & Products Routes
//     Route::get("/shop", [ProductController::class, "index"])->name("shop.index");
//     Route::get('/shop/filter', [ProductController::class, 'filter'])->name('shop.filter');
//     Route::get("/products/{slug}", [ProductController::class, "show"])->name("shop.show");

//     // Cart Routes
//     Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
//     Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
//     Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
//     Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');

//     // Checkout Routes
//     Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
//     Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
//     Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
// });

@require_once('user.php');


//Admin
Route::prefix("admin")->group(function () {

    Route::middleware("guest:admin")->group(function () {
        Route::get("login", [AdminLoginController::class, "index"])->name("admin.login");
        Route::post("login", [AdminLoginController::class, "authenticate"])->name("admin.authenticate");
    });

    Route::middleware("auth:admin")->group(function () {
        Route::get("/", [DashboardController::class, "index"])->name("admin.dashboard");
        Route::get("logout", [AdminLoginController::class, "logout"])->name("admin.logout");

        //Admin Category Routes
        Route::get("category", [AdminCategoryController::class, "index"])->name("admin.categories");
        Route::get('category/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('category/store', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('category/edit/{id}', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::put('categories/{id}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
        Route::get('categories/search', [AdminCategoryController::class, 'search'])->name('admin.categories.search');
        Route::delete('categories/{id}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');

        Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products');
        Route::get('/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
        Route::post('/products/store', [AdminProductController::class, 'store'])->name('admin.products.store');
        Route::get('/products/edit/{id}', [AdminProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/products/update/{id}', [AdminProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
        Route::get('/products/search', [AdminProductController::class, 'search'])->name('admin.products.search');

        Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
        Route::get('/orders/create', [AdminOrderController::class, 'create'])->name('admin.orders.create');
        Route::post('/orders/store', [AdminOrderController::class, 'store'])->name('admin.orders.store');
        Route::get('/orders/edit/{id}', [AdminOrderController::class, 'edit'])->name('admin.orders.edit');
        Route::put('/orders/update/{id}', [AdminOrderController::class, 'update'])->name('admin.orders.update');
        Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');
        Route::get('/orders/search', [AdminOrderController::class, 'search'])->name('admin.orders.search');
        Route::get('/orders/details/{id}', [AdminOrderController::class, 'details'])->name('admin.orders.details');
        Route::post('/orders/update-status/{id}', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users');
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
        Route::post('/users/store', [AdminUserController::class, 'store'])->name('admin.users.store');
        Route::get('/users/edit/{id}', [AdminUserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/update/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
        Route::get('/users/search', [AdminUserController::class, 'search'])->name('admin.users.search');

        Route::get('/roles', [AdminRoleController::class, 'index'])->name('admin.roles.index');
        Route::get('/roles/create', [AdminRoleController::class, 'create'])->name('admin.roles.create');
        Route::post('/roles/store', [AdminRoleController::class, 'store'])->name('admin.roles.store');
        Route::get('/roles/edit/{id}', [AdminRoleController::class, 'edit'])->name('admin.roles.edit');
        Route::put('/roles/update/{id}', [AdminRoleController::class, 'update'])->name('admin.roles.update');
        Route::delete('/roles/{id}', [AdminRoleController::class, 'destroy'])->name('admin.roles.destroy');
        Route::get('/roles/search', [AdminRoleController::class, 'search'])->name('admin.roles.search');
    });
});
