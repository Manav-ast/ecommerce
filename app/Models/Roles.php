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

    public $fillable = [
        "role_name",
        "description",
    ];

    public function admins()
    {
        return $this->hasMany(Admin::class, 'role_id');
    }
}
