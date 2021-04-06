<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;
    protected $table = 'subscribers';
    public $incrementing = false;
    protected $guarded = [];
    //protected $fillable = ['user_id', 'group_id', 'is_admin'];
}
