<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Define gates for admin permissions
        Gate::define('manage_categories', function ($admin) {
            return $admin->hasPermission('manage_categories');
        });

        Gate::define('manage_products', function ($admin) {
            return $admin->hasPermission('manage_products');
        });

        Gate::define('manage_orders', function ($admin) {
            return $admin->hasPermission('manage_orders');
        });

        Gate::define('manage_users', function ($admin) {
            return $admin->hasPermission('manage_users');
        });

        Gate::define('manage_roles', function ($admin) {
            return $admin->hasPermission('manage_roles');
        });

        Gate::define('manage_static_blocks', function ($admin) {
            return $admin->hasPermission('manage_static_blocks');
        });

        Gate::define('manage_page_blocks', function ($admin) {
            return $admin->hasPermission('manage_page_blocks');
        });

        // Super admin has all permissions
        Gate::before(function ($admin, $permission) {
            if ($admin->isSuperAdmin()) {
                return true;
            }
            return null;
        });
    }
}
