<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Post;

class Group extends Model
{
    use HasFactory;
    protected $table = 'groups_vk';
    protected $guarded = [];

    protected $appends = ['is_saved'];

    public function getIsSavedAttribute()
    {
        $user_id = auth()->user()->id;
        $saved_record = SavedRecord::all()->toArray();
//            ->where('object_id', $this->id);
        return $saved_record;
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Comment::class, 'author');
    }
    public function posts(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Post::class, 'author');
    }
}
