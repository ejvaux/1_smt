<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Http\Controllers\MES\model\Machine;
use App\Http\Controllers\MES\model\Component;
use App\Models\MatComp;
use App\MatLoadModel;

class MatCompInsert implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $req;
    public $tries = 5;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($req)
    {
        $this->req = $req;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $machine = $this->req['machine_id'];
        $m_code =substr($machine,0,-1);
        $mach = Machine::where('barcode',$m_code)->first();
        $line_id = $mach->line->linename->id;
        $component= Component::where('product_number',$this->req['new_PN'])->first();
        $m = MatComp::where('model_id',$this->req['model_id'])->where('line_id',$line_id)->latest('id')->first();
        
        if($m){
            $mt = $m->materials;
            $tu = '';
            foreach ($mt as $key => $value) {
                if(
                    strtoupper($value['machine']) == strtoupper($this->req['machine_id']) && 
                    $value['position'] == $this->req['position'] && 
                    $value['feeder'] == $this->req['feeder_slot']
                    )
                {
                    $tu = $key;
                    unset($mt[$tu]);
                }
            }

            $im = new MatComp;
            $im->model_id = $this->req['model_id'];
            $im->line_id = $line_id;
            $im->mat_load_id = $this->req['id'];
            $im->materials = $mt;
            $mt2 = $im->materials;
            $mt2[] = [
                    'component_id' => $component->id,
                    'machine' => strtoupper($this->req['machine_id']),
                    'position' => $this->req['position'],
                    'feeder' => $this->req['feeder_slot'],
                    'RID' => $this->req['comp_rid'],
                    'QTY' => $this->req['comp_qty'],
                    'matload_id' => $this->req['id']
                    ];
            $zz = array_values($mt2);
            $im->materials = $zz;            
            $im->save();
        }
        else{
            $im = new MatComp;
            $im->model_id = $this->req['model_id'];
            $im->line_id = $line_id;
            $im->mat_load_id = $this->req['id'];
            $mt = $im->materials;
            $mt[] = [
                    'component_id' => $component->id,
                    'machine' => strtoupper($this->req['machine_id']),
                    'position' => $this->req['position'],
                    'feeder' => $this->req['feeder_slot'],
                    'RID' => $this->req['comp_rid'],
                    'QTY' => $this->req['comp_qty'],
                    'matload_id' => $this->req['id']
                    ];
            $zzz = array_values($mt);        
            $im->materials = $zzz;
            $im->save();
        }
    }
}
