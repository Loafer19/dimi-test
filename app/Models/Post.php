<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public $casts = [
        'posted_at' => 'datetime',
    ];

    protected $guarded = [];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
