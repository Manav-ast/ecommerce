<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Admin extends Authenticatable
{

    use Notifiable, HasFactory, SoftDeletes;
    protected $table = "admins";

    public $fillable = [
        "name",
        "email",
        "password",
        "role_id",
        "phone_number",
        "status",
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isSuperAdmin()
    {
        return $this->role->is_super_admin == Role::STATUS_YES ? true : false;
    }

    public function hasPermission($permission)
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->role()->whereHas("permissions", function ($query) use ($permission) {
            $query->where("key", $permission);
        })->exists();
    }
}
