<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts_vk';
    protected $guarded = [];

    protected $appends = ['is_saved'];

    public function getIsSavedAttribute()
    {
        $user_id = auth()->user()->id;
        $saved_record = SavedRecord::all()->where('object_type', 'post')->where('object_id', $this->id)->where('user_id', $user_id)->toArray();
        return count($saved_record) > 0;
    }

    public function author(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }
}
