<?php

use App\Models\RolePermission;
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
        $tableName = (new RolePermission())->getTable();
        Schema::create($tableName, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("role_id");
            $table->foreign("role_id")->references("id")->on("roles");
            $table->unsignedBigInteger("permission_id");
            $table->foreign("permission_id")->references("id")->on("permissions");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableName = (new RolePermission())->getTable();
        Schema::dropIfExists($tableName);
    }
};
