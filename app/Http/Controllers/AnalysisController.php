<?php

namespace App\Http\Controllers;

use App\Jobs\AnalyseOjectJob;
use App\Jobs\AnalysisObjectsJob;
use App\Jobs\EndAnalyseJob;
use App\Models\AnalysisRequest;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function addToAnalysisQuery(Request $request) {
        $data = [
            'name' =>  $request['reqName'],
            'reason' => $request['reqReason'],
            'status' => 'created',
            'user_id' => auth()->user()->id,
        ];

        $request_obj = AnalysisRequest::create($data);

        $analyseJobs = [];

        foreach ($request['objectInputs'] as $key=>$value)
        {
            $analyseJobs[] = new AnalyseOjectJob($request_obj->id, $value['objType'], $value['objId']);
        }

        $firstJob = new AnalysisObjectsJob($request_obj->id);

        $firstJob::withChain(array_merge($analyseJobs, [new EndAnalyseJob($request_obj->id)]))->dispatch($request_obj->id);

         return response()->json([
             'result' => 'success',
             'requestNumber' => '#'.(string)$request_obj->id,
         ]);
    }
}
