<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVK extends Model
{
    use HasFactory;
    protected $fillable = ['wall_id', 'fullname', 'avatar', 'privacy', 'toxicity'];
}
