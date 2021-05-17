<?php

namespace App\Http\Controllers;

use App\Models\AnalysisRequest;
use Illuminate\Http\Request;

class AnalysisRequestsController extends Controller
{
    public function getAll($user_id) {
        $requests = AnalysisRequest::all()->where('user_id', $user_id)->toArray();
        return response()->json($requests);
    }

    public function getOne($req_id) {
        $request = AnalysisRequest::find($req_id);
        return response()->json($request);
    }
}
