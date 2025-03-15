<?php

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomepageController;
use Illuminate\Support\Facades\Route;

Route::middleware("guest:user")->group(function () {
    Route::get("login", [LoginController::class, "index"])->name("user.login");
    Route::post("login", [LoginController::class, "authenticate"])->name("user.authenticate");
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('user.register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware("auth:user")->group(function () {
    Route::get("logout", [LoginController::class, "logout"])->name("user.logout");
    Route::get("/", [HomepageController::class, "index"])->name("homepage");
});

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
        Route::get('/admin/categories/search', [AdminCategoryController::class, 'search'])->name('admin.categories.search');
        Route::delete('categories/{id}', [AdminCategoryController::class, 'delete'])->name('admin.categories.delete');

        //Admin Products Routes
        
    });
});
