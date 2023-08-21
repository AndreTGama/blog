<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'category_id'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    /**
     * Get post.
     */
    public function posts()
    {
        return $this->belongsToMany(Posts::class, 'posts_has_categories', 'category_id', 'post_id');
    }
}
