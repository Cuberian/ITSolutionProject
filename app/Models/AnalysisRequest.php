<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalysisRequest extends Model
{
    use HasFactory;

    protected $table = 'analysis_request';
    protected  $guarded = [];
    protected $appends = ['analysis_request_objects'];

    public function getAnimalTraitsAttribute()
    {
        return $this->belongsTo(AnalysisRequestObject::class, 'request_id', 'id')->getResults();
    }
}
