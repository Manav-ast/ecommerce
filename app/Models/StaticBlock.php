<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaticBlock extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'static_blocks';

    protected $fillable = [
        'slug',
        'title',
        'content',
        'status',
    ];

    /**
     * Get the status as a readable format.
     */
    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }
}
