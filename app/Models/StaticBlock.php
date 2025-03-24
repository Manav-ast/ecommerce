<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticBlock extends Model
{
    use HasFactory;

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
