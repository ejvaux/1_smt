<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\MatComp;
use App\Models\MatSnComp;

class CompSnInsert implements ShouldQueue
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
        $mat_comp = MatComp::where('id',$this->mat_comp_id)->first();
        foreach ($mat_comp->materials as $key => $value) {
            $comp = MatSnComp::where('model_id',$mat_comp->model_id)->where('line_id',$mat_comp->line_id)->where('component_id',$key)->where('RID',$value['RID'])->first();
            if($comp){                                
                /* $comp->sn = array($this->sn); */
                $cc = $comp->sn;
                $cc[] = $this->sn;
                $comp->sn = $cc;
                $comp->save();
            }
            else{
                $c = new MatSnComp;
                $c->model_id = $mat_comp->model_id;
                $c->line_id = $mat_comp->line_id;
                $c->component_id = $key;
                $c->RID = $value['RID'];
                $c->sn = array($this->sn);
                $c->save();
            }
        }
    }
}
