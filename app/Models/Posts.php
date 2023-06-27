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
}
