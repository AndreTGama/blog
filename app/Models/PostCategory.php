<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'post_id',
        'category_id',
    ];

    /**
     * Get the post that owns the post category.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the category that owns the post category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
