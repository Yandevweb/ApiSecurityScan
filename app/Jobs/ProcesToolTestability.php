<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\Api\ControllerTool;
use App\Http\Controllers\Controller;

class ProcesToolTestability implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $tool;
    public function __construct(ControllerTool $tool)
    {
        $this->tool=$tool;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle( )
    {

        $results = [];

        $results[] = $this->tool->toolTestability();
        //dd($results);
        //var_dump(response()->json(['status'=>'success', 'id' => "toto",'plugins' => $results], 200));



        //return response()->json(['status'=>'success', 'id' => "toto",'plugins' => $results], 200);

        //return $results;
    }
}
