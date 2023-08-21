<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comments extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'comment',
        'aprove',
        'author_id',
        'post_id',
        'moderator_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    /**
     * Get Posts made by users
     *
     * @return void
     */
    public function posts()
    {
        return $this->belongsTo(Posts::class, 'post_id', 'id');
    }
}
