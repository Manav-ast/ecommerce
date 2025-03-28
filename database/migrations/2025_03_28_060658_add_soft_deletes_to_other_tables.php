<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add softDeletes to all relevant tables
        $tables = [
            'products',
            'categories',
            'orders',
            'order_items',
            'invoices',
            'addresses',
            'payments',
            'customers',
            'admins',
            'roles',
            'page_block',
            'static_blocks'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'deleted_at')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->softDeletes();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop softDeletes from all tables
        $tables = [
            'products',
            'categories',
            'orders',
            'order_items',
            'invoices',
            'addresses',
            'payments',
            'customers',
            'admins',
            'roles',
            'page_block',
            'static_blocks'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'deleted_at')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropSoftDeletes();
                });
            }
        }
    }
};
