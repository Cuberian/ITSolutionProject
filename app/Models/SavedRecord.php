<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedRecord extends Model
{
    use HasFactory;
    protected $table = 'saved_records';
    protected $guarded = [];

    public $objHelper = [
        'group'=> Group::class,
        'user'=> UserVK::class,
        'post'=> Post::class
    ];

    protected $appends = ['object_value'];

    public function getObjectValueAttribute()
    {
        return $this->objHelper[$this->object_type]::find($this->object_id);
    }
}
