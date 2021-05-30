<?php

namespace App\Jobs;

use App\Models\AnalysisRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StartAnalyseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $req_id;

    public function __construct($request_id)
    {
        $this->req_id = $request_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $analysis_request = AnalysisRequest::find($this->req_id);
        $analysis_request->update(['status' => 'in_process']);
    }
}
