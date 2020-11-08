<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Post;

class UserVK extends Model
{
    use HasFactory;
    protected $table = 'users_vk';
    protected $fillable = ['wall_id', 'fullname', 'avatar', 'privacy', 'toxicity'];

    public function comments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Comment::class, 'author');
    }
    public function posts(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Post::class, 'author');
    }
}
