<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Product;
use App\Services\CartService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CartService::class, function ($app) {
            return new CartService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Check if the categories table exists before trying to query it
        if (Schema::hasTable('categories')) {
            // Use DB facade instead of the model to avoid soft delete issues during migration
            $categories = DB::table('categories')->get();
            View::share('categories', $categories);
        }
        // View::composer('*', function ($view) {
        //     $view->with('categories', Category::all()); 
        // });
    }
}
