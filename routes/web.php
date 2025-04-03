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
use App\Http\Controllers\Admin\AdminPageBlockController;
use App\Http\Controllers\Admin\AdminController;

@require('user.php');

//Admin
Route::prefix("admin")->group(function () {

    Route::middleware("guest:admin")->group(function () {
        Route::get("/login", [AdminLoginController::class, "index"])->name("admin.login");
        Route::post("/login", [AdminLoginController::class, "authenticate"])->name("admin.authenticate");
    });

    Route::middleware("auth:admin")->group(function () {
        //login and logout routes
        Route::get("/dashboard", [DashboardController::class, "index"])->name("admin.dashboard");
        Route::get("/logout", [AdminLoginController::class, "logout"])->name("admin.logout");

        // Admin management routes
        Route::group(['middleware' => 'can:manage_admins'], function () {
            Route::get('/admins', [AdminController::class, 'index'])->name('admin.admins.index');
            Route::get('/admins/create', [AdminController::class, 'create'])->name('admin.admins.create');
            Route::post('/admins', [AdminController::class, 'store'])->name('admin.admins.store');
            Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])->name('admin.admins.edit');
            Route::put('/admins/{admin}', [AdminController::class, 'update'])->name('admin.admins.update');
            Route::delete('/admins/{admin}', [AdminController::class, 'destroy'])->name('admin.admins.destroy');
            Route::get('/admins/search', [AdminController::class, 'search'])->name('admin.admins.search');
            Route::post('admins/check-email', [DuplicateCheckController::class, 'checkEmail']);
            Route::post('admins/check-phone', [DuplicateCheckController::class, 'checkPhone']);
        });

        //Admin Category Routes
        Route::group(['middleware' => 'can:manage_categories'], function () {
            Route::get("/category", [AdminCategoryController::class, "index"])->name("admin.categories");
            Route::get('/category/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
            Route::post('/category/store', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
            Route::get('/category/edit/{id}', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
            Route::put('/categories/{id}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
            Route::get('/categories/search', [AdminCategoryController::class, 'search'])->name('admin.categories.search');
            Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');
            Route::get('/categories/trashed', [AdminCategoryController::class, 'trashed'])->name('admin.categories.trashed');
            Route::post('/categories/{id}/restore', [AdminCategoryController::class, 'restore'])->name('admin.categories.restore');
            Route::delete('/categories/{id}/force-delete', [AdminCategoryController::class, 'forceDelete'])->name('admin.categories.force-delete');
        });

        //Admin products routes
        Route::group(['middleware' => 'can:manage_products'], function () {
            Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products');
            Route::get('/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
            Route::post('/products/store', [AdminProductController::class, 'store'])->name('admin.products.store');
            Route::get('/products/edit/{id}', [AdminProductController::class, 'edit'])->name('admin.products.edit');
            Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('admin.products.update');
            Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
            Route::get('/products/search', [AdminProductController::class, 'search'])->name('admin.products.search');
            Route::get('/products/trashed', [AdminProductController::class, 'trashed'])->name('admin.products.trashed');
            Route::post('/products/{id}/restore', [AdminProductController::class, 'restore'])->name('admin.products.restore');
            Route::delete('/products/{id}/force-delete', [AdminProductController::class, 'forceDelete'])->name('admin.products.force-delete');
        });

        //Admin orders routes
        Route::group(['middleware' => 'can:manage_orders'], function () {
            Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
            Route::get('/orders/search', [AdminOrderController::class, 'search'])->name('admin.orders.search');
            Route::get('/orders/create', [AdminOrderController::class, 'create'])->name('admin.orders.create');
            Route::post('/orders/store', [AdminOrderController::class, 'store'])->name('admin.orders.store');
            Route::get('/orders/edit/{id}', [AdminOrderController::class, 'edit'])->name('admin.orders.edit');
            Route::put('/orders/update/{id}', [AdminOrderController::class, 'update'])->name('admin.orders.update');
            Route::get('/orders/details/{id}', [AdminOrderController::class, 'details'])->name('admin.orders.details');
            Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update-status');
            Route::post('/orders/update-status/{id}', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
            // This wildcard route should be last to avoid conflicts
            Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
        });

        //Admin users routes
        Route::group((['middleware' => 'can:manage_users']), function () {
            Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users');
            Route::get('/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
            Route::post('/users/store', [AdminUserController::class, 'store'])->name('admin.users.store');
            Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
            Route::put('/users/{id}/status', [AdminUserController::class, 'updateStatus'])->name('admin.users.update-status');
            Route::get('/users/edit/{id}', [AdminUserController::class, 'edit'])->name('admin.users.edit');
            Route::put('/users/update/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
            Route::get('/users/search', [AdminUserController::class, 'search'])->name('admin.users.search');
            Route::post('users/check-email', [DuplicateCheckController::class, 'checkEmail']);
            Route::post('users/check-phone', [DuplicateCheckController::class, 'checkPhone']);
        });

        //Admin roles routes
        Route::group(['middleware' => 'can:manage_roles'], function () {
            Route::get('/roles', [AdminRoleController::class, 'index'])->name('admin.roles');
            Route::get('/roles/create', [AdminRoleController::class, 'create'])->name('admin.roles.create');
            Route::post('/roles/store', [AdminRoleController::class, 'store'])->name('admin.roles.store');
            Route::get('/roles/edit/{id}', [AdminRoleController::class, 'edit'])->name('admin.roles.edit');
            Route::put('/roles/{id}', [AdminRoleController::class, 'update'])->name('admin.roles.update');
            Route::delete('/roles/{id}', [AdminRoleController::class, 'destroy'])->name('admin.roles.destroy');
            Route::get('/roles/search', [AdminRoleController::class, 'search'])->name('admin.roles.search');
        });

        //Admin static blocks routes
        Route::group(['middleware' => 'can:manage_static_blocks'], function () {
            Route::get('/static-blocks', [AdminStaticBlockController::class, 'index'])->name('admin.static-blocks.index');
            Route::get('/static-blocks/create', [AdminStaticBlockController::class, 'create'])->name('admin.static-blocks.create');
            Route::post('/static-blocks/store', [AdminStaticBlockController::class, 'store'])->name('admin.static-blocks.store');
            Route::get('/static-blocks/{id}/edit', [AdminStaticBlockController::class, 'edit'])->name('admin.static-blocks.edit');
            Route::put('/static-blocks/{id}', [AdminStaticBlockController::class, 'update'])->name('admin.static-blocks.update');
            Route::delete('/static-blocks/{id}', [AdminStaticBlockController::class, 'destroy'])->name('admin.static-blocks.destroy');
            Route::get('/static-blocks/search', [AdminStaticBlockController::class, 'search'])->name('admin.static-blocks.search');
        });

        //Admin page blocks routes
        Route::group((['middleware' => 'can:manage_page_blocks']), function () {
            Route::get('/page-blocks', [AdminPageBlockController::class, 'index'])->name('admin.page-blocks.index')->can('manage_page_blocks');
            Route::get('/page-blocks/create', [AdminPageBlockController::class, 'create'])->name('admin.page-blocks.create')->can('manage_page_blocks');
            Route::post('/page-blocks/store', [AdminPageBlockController::class, 'store'])->name('admin.page-blocks.store')->can('manage_page_blocks');
            Route::get('/page-blocks/{id}/edit', [AdminPageBlockController::class, 'edit'])->name('admin.page-blocks.edit')->can('manage_page_blocks');
            Route::put('/page-blocks/{id}', [AdminPageBlockController::class, 'update'])->name('admin.page-blocks.update')->can('manage_page_blocks');
            Route::delete('/page-blocks/{id}', [AdminPageBlockController::class, 'destroy'])->name('admin.page-blocks.destroy')->can('manage_page_blocks');
            Route::get('/page-blocks/search', [AdminPageBlockController::class, 'search'])->name('admin.page-blocks.search')->can('manage_page_blocks');
        });
    });
});

// Admin invoice routes
Route::middleware("auth:admin")->prefix('admin')->name('admin.')->group(function () {
    Route::get('/orders/{order}/invoice/download', [App\Http\Controllers\Admin\AdminOrderController::class, 'downloadInvoice'])
        ->name('orders.invoice.download')->can('manage_orders');
});
