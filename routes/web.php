<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminRoleController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\DuplicateCheckController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminStaticBlockController;
use App\Http\Controllers\Admin\AdminPageBlockController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\SearchController;
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
        Route::get('/admins', [AdminController::class, 'index'])->name('admin.admins.index')->can('manage_admins');
        Route::get('/admins/create', [AdminController::class, 'create'])->name('admin.admins.create')->can('manage_admins');
        Route::post('/admins', [AdminController::class, 'store'])->name('admin.admins.store')->can('manage_admins');
        Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])->name('admin.admins.edit')->can('manage_admins');
        Route::put('/admins/{admin}', [AdminController::class, 'update'])->name('admin.admins.update')->can('manage_admins');
        Route::delete('/admins/{admin}', [AdminController::class, 'destroy'])->name('admin.admins.destroy')->can('manage_admins');
        Route::get('/admins/search', [AdminUserController::class, 'search'])->name('admin.admins.search')->can('manage_admins');
        Route::post('admins/check-email', [DuplicateCheckController::class, 'checkEmail'])->can('manage_admins');
        Route::post('admins/check-phone', [DuplicateCheckController::class, 'checkPhone'])->can('manage_admins');

        //Admin Category Routes
        Route::get("/category", [AdminCategoryController::class, "index"])->name("admin.categories")->can('manage_categories');
        Route::get('/category/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create')->can('manage_categories');
        Route::post('/category/store', [AdminCategoryController::class, 'store'])->name('admin.categories.store')->can('manage_categories');
        Route::get('/category/edit/{id}', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit')->can('manage_categories');
        Route::put('/categories/{id}', [AdminCategoryController::class, 'update'])->name('admin.categories.update')->can('manage_categories');
        Route::get('/categories/search', [AdminCategoryController::class, 'search'])->name('admin.categories.search')->can('manage_categories');
        Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy')->can('manage_categories');
        Route::get('/categories/trashed', [AdminCategoryController::class, 'trashed'])->name('admin.categories.trashed')->can('manage_categories');
        Route::post('/categories/{id}/restore', [AdminCategoryController::class, 'restore'])->name('admin.categories.restore')->can('manage_categories');
        Route::delete('/categories/{id}/force-delete', [AdminCategoryController::class, 'forceDelete'])->name('admin.categories.force-delete')->can('manage_categories');

        //Admin products routes
        Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products')->can('manage_products');
        Route::get('/products/create', [AdminProductController::class, 'create'])->name('admin.products.create')->can('manage_products');
        Route::post('/products/store', [AdminProductController::class, 'store'])->name('admin.products.store')->can('manage_products');
        Route::get('/products/edit/{id}', [AdminProductController::class, 'edit'])->name('admin.products.edit')->can('manage_products');
        Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('admin.products.update')->can('manage_products');
        Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy')->can('manage_products');
        Route::get('/products/search', [AdminProductController::class, 'search'])->name('admin.products.search')->can('manage_products');
        Route::get('/products/trashed', [AdminProductController::class, 'trashed'])->name('admin.products.trashed')->can('manage_products');
        Route::post('/products/{id}/restore', [AdminProductController::class, 'restore'])->name('admin.products.restore')->can('manage_products');
        Route::delete('/products/{id}/force-delete', [AdminProductController::class, 'forceDelete'])->name('admin.products.force-delete')->can('manage_products');

        //Admin orders routes
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders')->can('manage_orders');
        Route::get('/orders/create', [AdminOrderController::class, 'create'])->name('admin.orders.create')->can('manage_orders');
        Route::post('/orders/store', [AdminOrderController::class, 'store'])->name('admin.orders.store')->can('manage_orders');
        Route::get('/orders/edit/{id}', [AdminOrderController::class, 'edit'])->name('admin.orders.edit')->can('manage_orders');
        Route::put('/orders/update/{id}', [AdminOrderController::class, 'update'])->name('admin.orders.update')->can('manage_orders');
        Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show')->can('manage_orders');
        Route::get('/orders/details/{id}', [AdminOrderController::class, 'details'])->name('admin.orders.details')->can('manage_orders');
        Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update-status')->can('manage_orders');
        Route::get('/orders/search', [AdminOrderController::class, 'search'])->name('admin.orders.search')->can('manage_orders');
        Route::post('/orders/update-status/{id}', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus')->can('manage_orders');

        //Admin users routes
        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users')->can('manage_users');
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('admin.users.create')->can('manage_users');
        Route::post('/users/store', [AdminUserController::class, 'store'])->name('admin.users.store')->can('manage_users');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy')->can('manage_users');
        Route::put('/users/{id}/status', [AdminUserController::class, 'updateStatus'])->name('admin.users.update-status')->can('manage_users');
        Route::get('/users/edit/{id}', [AdminUserController::class, 'edit'])->name('admin.users.edit')->can('manage_users');
        Route::put('/users/update/{id}', [AdminUserController::class, 'update'])->name('admin.users.update')->can('manage_users');
        Route::get('/users/search', [AdminUserController::class, 'search'])->name('admin.users.search')->can('manage_users');
        Route::post('users/check-email', [DuplicateCheckController::class, 'checkEmail'])->can('manage_users');
        Route::post('users/check-phone', [DuplicateCheckController::class, 'checkPhone'])->can('manage_users');

        //Admin roles routes
        Route::get('/roles', [AdminRoleController::class, 'index'])->name('admin.roles')->can('manage_roles');
        Route::get('/roles/create', [AdminRoleController::class, 'create'])->name('admin.roles.create')->can('manage_roles');
        Route::post('/roles/store', [AdminRoleController::class, 'store'])->name('admin.roles.store')->can('manage_roles');
        Route::get('/roles/edit/{id}', [AdminRoleController::class, 'edit'])->name('admin.roles.edit')->can('manage_roles');
        Route::put('/roles/{id}', [AdminRoleController::class, 'update'])->name('admin.roles.update')->can('manage_roles');
        Route::delete('/roles/{id}', [AdminRoleController::class, 'destroy'])->name('admin.roles.destroy')->can('manage_roles');
        Route::get('/roles/search', [AdminRoleController::class, 'search'])->name('admin.roles.search')->can('manage_roles');

        //Admin static blocks routes
        Route::get('/static-blocks', [AdminStaticBlockController::class, 'index'])->name('admin.static-blocks.index')->can('manage_static_blocks');
        Route::get('/static-blocks/create', [AdminStaticBlockController::class, 'create'])->name('admin.static-blocks.create')->can('manage_static_blocks');
        Route::post('/static-blocks/store', [AdminStaticBlockController::class, 'store'])->name('admin.static-blocks.store')->can('manage_static_blocks');
        Route::get('/static-blocks/{id}/edit', [AdminStaticBlockController::class, 'edit'])->name('admin.static-blocks.edit')->can('manage_static_blocks');
        Route::put('/static-blocks/{id}', [AdminStaticBlockController::class, 'update'])->name('admin.static-blocks.update')->can('manage_static_blocks');
        Route::delete('/static-blocks/{id}', [AdminStaticBlockController::class, 'destroy'])->name('admin.static-blocks.destroy')->can('manage_static_blocks');
        Route::get('/static-blocks/search', [AdminStaticBlockController::class, 'search'])->name('admin.static-blocks.search')->can('manage_static_blocks');

        //Admin page blocks routes
        Route::get('/page-blocks', [AdminPageBlockController::class, 'index'])->name('admin.page-blocks.index')->can('manage_page_blocks');
        Route::get('/page-blocks/create', [AdminPageBlockController::class, 'create'])->name('admin.page-blocks.create')->can('manage_page_blocks');
        Route::post('/page-blocks/store', [AdminPageBlockController::class, 'store'])->name('admin.page-blocks.store')->can('manage_page_blocks');
        Route::get('/page-blocks/{id}/edit', [AdminPageBlockController::class, 'edit'])->name('admin.page-blocks.edit')->can('manage_page_blocks');
        Route::put('/page-blocks/{id}', [AdminPageBlockController::class, 'update'])->name('admin.page-blocks.update')->can('manage_page_blocks');
        Route::delete('/page-blocks/{id}', [AdminPageBlockController::class, 'destroy'])->name('admin.page-blocks.destroy')->can('manage_page_blocks');
        Route::get('/page-blocks/search', [AdminPageBlockController::class, 'search'])->name('admin.page-blocks.search')->can('manage_page_blocks');
    });
});

// Admin invoice routes
Route::middleware("auth:admin")->prefix('admin')->name('admin.')->group(function () {
    Route::get('/orders/{order}/invoice/download', [App\Http\Controllers\Admin\AdminOrderController::class, 'downloadInvoice'])
        ->name('orders.invoice.download')->can('manage_orders');
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


//check for the route in this file from the work/ecommerce project