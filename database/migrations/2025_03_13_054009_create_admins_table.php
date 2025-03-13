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
        Schema::create('admins', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('name', 100);
            $table->string('password', 255);
            $table->string('email', 100);
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->timestamps(); // Includes created_at and updated_at (default columns)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
