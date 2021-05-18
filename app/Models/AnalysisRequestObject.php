<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalysisRequestObject extends Model
{
    use HasFactory;

    protected $table = 'analysis_request_objects';
    protected  $guarded = [];

    public $objHelper = [
        'group'=> Group::class,
        'user'=> UserVK::class,
        'post'=> Post::class
    ];

    protected $appends = ['object_value'];

    public function getObjectValueAttribute()
    {
        return $this->objHelper[$this->type]::find($this->object_id);
    }
}
