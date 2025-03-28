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
    ];
}
