<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageBlock extends Model
{
    use HasFactory, SoftDeletes;

    const ACTIVE_STATUS = 'active';

    protected $table = 'page_block';

    protected $fillable = [
        'slug',
        'title',
        'content',
        'status',
    ];
}
