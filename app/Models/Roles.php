<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Roles extends Model
{
    use Notifiable, HasFactory, SoftDeletes;
    protected $table = "roles";

    const STATUS_YES = "yes";
    const STATUS_NO =   "no";

    public $fillable = [
        "name",
        "is_super_admin"
    ];

    public function admins()
    {
        return $this->hasMany(Admin::class, 'role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permissions::class, RolePermission::class, "role_id", "permission_id");
    }
}
