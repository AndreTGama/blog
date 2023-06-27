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
        'comment',
        'aprove',
        'author_id',
        'post_id',
        'post_id'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];
}
