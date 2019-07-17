<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\MatComp;
use App\Models\MatComp1;
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
        $mat_comp1 = MatComp1::where('id',$this->mat_comp_id);
        if($mat_comp1->first()){
            $mat_comp = $mat_comp1->first();
            foreach ($mat_comp->materials as $key => $value) {
                $comp = MatSnComp::where('mat_comp_id',$mat_comp->id)->where('component_id',$key)->where('RID',$value['RID'])->OrderBy('id','DESC')->first();
                if($comp){                                
                    /* $comp->sn = array($this->sn); */
                    $cc = $comp->sn;
                    if(count($comp->sn) > 499){
                        $c = new MatSnComp;
                        $c->model_id = $mat_comp->model_id;
                        $c->line_id = $mat_comp->line_id;
                        $c->mat_comp_id = $mat_comp->id;
                        $c->component_id = $key;
                        $c->RID = $value['RID'];
                        $c->sn = array($this->sn);
                        $c->save();
                    }
                    else{
                        $cc[] = $this->sn;
                        $comp->sn = $cc;
                        $comp->mat_comp_id = $mat_comp->id;
                        $comp->save();
                    }                    
                }
                else{
                    $c = new MatSnComp;
                    $c->model_id = $mat_comp->model_id;
                    $c->line_id = $mat_comp->line_id;
                    $c->mat_comp_id = $mat_comp->id;
                    $c->component_id = $key;
                    $c->RID = $value['RID'];
                    $c->sn = array($this->sn);
                    $c->save();
                }
            }
        }        
    }
}
