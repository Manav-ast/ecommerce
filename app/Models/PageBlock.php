<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PageBlock extends Model
{
    use HasFactory;

    const ACTIVE_STATUS = 'active';

    protected $table = 'page_block';

    protected $fillable = [
        'slug',
        'title',
        'content',
        'status',
    ];
}
