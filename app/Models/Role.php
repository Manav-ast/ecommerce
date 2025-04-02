<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "roles";

    const STATUS_YES = "yes";
    const STATUS_NO = "no";

    public $fillable = [
        "name",
        "is_super_admin"
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id');
    }
}
