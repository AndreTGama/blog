<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Posts extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'post',
        'aprove',
        'author_id',
        'moderator_id',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];
    /**
     * Get all of the categories for the post.
     */
    public function categories()
    {
        return $this->belongsToMany(Categories::class, 'posts_has_categories', 'post_id', 'category_id');
    }
    /**
     * Get all of the commnets for the post.
     */
    public function comments()
    {
        return $this->hasMany(Comments::class, 'post_id', 'id');
    }
}
