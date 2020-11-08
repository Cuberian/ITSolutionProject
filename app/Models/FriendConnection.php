<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendConnection extends Model
{
    use HasFactory;
    protected $table = 'friends_connection';
    protected $fillable = ['user_id', 'friend_id', 'is_frien'];
}