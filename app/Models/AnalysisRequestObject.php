<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalysisRequestObject extends Model
{
    use HasFactory;

    protected $table = 'analysis_request_objects';
    protected  $guarded = [];
}
