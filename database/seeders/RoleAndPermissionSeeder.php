<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'manage_categories' => 'Manage Categories',
            'manage_products' => 'Manage Products',
            'manage_orders' => 'Manage Orders',
            'manage_users' => 'Manage Users',
            'manage_roles' => 'Manage Roles',
            'manage_static_blocks' => 'Manage Static Blocks',
            'manage_page_blocks' => 'Manage Page Blocks',
        ];

        foreach ($permissions as $key => $name) {
            Permission::create([
                'name' => $name,
                'key' => $key,
            ]);
        }

        // Create super admin role
        $superAdminRole = Role::create([
            'name' => 'Super Admin',
            'is_super_admin' => Role::STATUS_YES,
        ]);

        // Attach all permissions to super admin role
        $superAdminRole->permissions()->attach(Permission::all());

        // Create admin role with limited permissions
        $adminRole = Role::create([
            'name' => 'Admin',
            'is_super_admin' => Role::STATUS_NO,
        ]);

        // Attach specific permissions to admin role
        $adminRole->permissions()->attach(
            Permission::whereIn('key', [
                'manage_categories',
                'manage_products',
                'manage_orders',
                'manage_users',
            ])->get()
        );
    }
}
