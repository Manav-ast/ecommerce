<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    protected $table = "permissions";

    public $fillable = [
        "name",
        "key",
    ];

    public function roles()
    {
        return $this->belongsToMany(Roles::class, RolePermission::class, "permission_id", "role_id");
    }
}
