<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\CompSnInsert;

class RemoteInsert implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sn;
    protected $mat_comp_id;
    public $tries = 5;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($sn,$mat_comp_id)
    {
        $this->sn = $sn;
        $this->mat_comp_id = $mat_comp_id;        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        CompSnInsert::dispatch($this->sn,$this->mat_comp_id)->onConnection('database2');
    }
}
