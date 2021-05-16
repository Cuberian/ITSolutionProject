<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
<<<<<<< HEAD
    protected $table = 'posts_vk';
    protected $guarded = [];
=======
    protected $table='posts_vk';

    protected $guarded = [];
    //protected $fillable = ['author_id', 'author_type', 'wall_id', 'text', 'toxicity'];
>>>>>>> master

    public function author(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }
}
