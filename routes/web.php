<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminRoleController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\DuplicateCheckController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminStaticBlockController;
use App\Http\Controllers\HomepageController;

@require_once('user.php');

//Admin
Route::prefix("admin")->group(function () {

    Route::middleware("guest:admin")->group(function () {
        Route::get("login", [AdminLoginController::class, "index"])->name("admin.login");
        Route::post("login", [AdminLoginController::class, "authenticate"])->name("admin.authenticate");
    });

    Route::middleware("auth:admin")->group(function () {
        //login and logout routes
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

        //Admin products routes
        Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products');
        Route::get('/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
        Route::post('/products/store', [AdminProductController::class, 'store'])->name('admin.products.store');
        Route::get('/products/edit/{id}', [AdminProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/products/update/{id}', [AdminProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
        Route::get('/products/search', [AdminProductController::class, 'search'])->name('admin.products.search');

        //Admin orders routes
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
        Route::get('/orders/create', [AdminOrderController::class, 'create'])->name('admin.orders.create');
        Route::post('/orders/store', [AdminOrderController::class, 'store'])->name('admin.orders.store');
        Route::get('/orders/edit/{id}', [AdminOrderController::class, 'edit'])->name('admin.orders.edit');
        Route::put('/orders/update/{id}', [AdminOrderController::class, 'update'])->name('admin.orders.update');
        Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');
        Route::get('/orders/search', [AdminOrderController::class, 'search'])->name('admin.orders.search');
        Route::get('/orders/details/{id}', [AdminOrderController::class, 'details'])->name('admin.orders.details');
        Route::post('/orders/update-status/{id}', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

        //Admin users routes
        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users');
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
        Route::post('/users/store', [AdminUserController::class, 'store'])->name('admin.users.store');
        Route::get('/users/edit/{id}', [AdminUserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/update/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
        Route::get('/users/search', [AdminUserController::class, 'search'])->name('admin.users.search');
        Route::post('users/check-email', [DuplicateCheckController::class, 'checkEmail']);
        Route::post('users/check-phone', [DuplicateCheckController::class, 'checkPhone']);

        //Admin roles routes
        Route::get('/roles', [AdminRoleController::class, 'index'])->name('admin.roles.index');
        Route::get('/roles/create', [AdminRoleController::class, 'create'])->name('admin.roles.create');
        Route::post('/roles/store', [AdminRoleController::class, 'store'])->name('admin.roles.store');
        Route::get('/roles/edit/{id}', [AdminRoleController::class, 'edit'])->name('admin.roles.edit');
        Route::put('/roles/update/{id}', [AdminRoleController::class, 'update'])->name('admin.roles.update');
        Route::delete('/roles/{id}', [AdminRoleController::class, 'destroy'])->name('admin.roles.destroy');
        Route::get('/roles/search', [AdminRoleController::class, 'search'])->name('admin.roles.search');

        //Admin static blocks routes
        Route::get('/static-blocks', [AdminStaticBlockController::class, 'index'])->name('admin.static_blocks.index');
        Route::get('/static-blocks/create', [AdminStaticBlockController::class, 'create'])->name('admin.static_blocks.create');
        Route::post('/static-blocks/store', [AdminStaticBlockController::class, 'store'])->name('admin.static_blocks.store');
        Route::get('/static-blocks/edit/{id}', [AdminStaticBlockController::class, 'edit'])->name('admin.static_blocks.edit');
        Route::put('/static-blocks/update/{id}', [AdminStaticBlockController::class, 'update'])->name('admin.static_blocks.update');
        Route::delete('/static-blocks/{id}', [AdminStaticBlockController::class, 'destroy'])->name('admin.static_blocks.destroy');
        Route::get('/static-blocks/search', [AdminStaticBlockController::class, 'search'])->name('admin.static_blocks.search');
    });
});
