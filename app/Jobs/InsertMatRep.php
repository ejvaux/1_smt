<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\MaterialReport;
use App\Custom\CustomFunctions;
use App\Http\Controllers\MES\model\Feeder;
use App\Models\MatSnComp;
use Carbon\Carbon;

class InsertMatRep implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $matload;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($matload)
    {
        $this->matload = $matload;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $today = Date('Y-m-d');
        $dt = Carbon::parse($today)->subday();

        // Get total system quantity
        $reel = CustomFunctions::getQrData($this->matload->ReelInfo,'RID');
        $total = 0;
        $serials = MatSnComp::select('id','mat_comp_id','sn','RID','model_id','component_id')->where('RID',$reel)->get();
        foreach ($serials as $serial) {            
            $total += count($serial->sn);
        }
        // End

        // Get Usage
        $u = Feeder::where('model_id',$this->matload->model_id)
                ->where('line_id',$this->matload->machine->line->linename->id)
                ->where('machine_type_id',$this->matload->machine->machine_type_id)
                ->where('table_id',$this->matload->table_id)
                ->where('mounter_id',$this->matload->mounter_id)
                ->where('pos_id',$this->matload->pos_id)
                ->max('usage'); 
        // End

        $line = $this->matload->machine->line->linename->name;
        $pcbPN = $this->matload->model->item_code;
        $program = $this->matload->model->program_name;
        $reelID = $reel;
        $compPN = CustomFunctions::getQrData($this->matload->ReelInfo,'PN');
        $feedTime = $this->matload->created_at;
        $reelQTY = CustomFunctions::getQrData($this->matload->ReelInfo,'QTY');
        $usage = $u;
        if ($usage) {
            $targetQTY = $reelQTY/$usage;
        }
        else{
            $targetQTY = $reelQTY;
        }
        $sysQTY = $total;
        $acc = round(($sysQTY/$targetQTY) * 100,2);
        $matloadID = $this->matload->id;
        $date = $dt;

        $rep = MaterialReport::where('mat_load_id',$matloadID)->first();

        if($rep){
            $rep->line = $line;
            $rep->pcb_pn = $pcbPN;
            $rep->program = $program;
            $rep->reel_id = $reelID;
            $rep->component_pn = $compPN;
            $rep->feed_time = $feedTime;
            $rep->reel_qty = $reelQTY;
            $rep->usage = $usage;
            $rep->target_qty = $targetQTY;
            $rep->sys_qty = $sysQTY;
            $rep->accuracy = $acc;
            $rep->mat_load_id = $matloadID;
            $rep->date = $date;
            $rep->save();
        }
        else{
            $mr = new MaterialReport;
            $mr->line = $line;
            $mr->pcb_pn = $pcbPN;
            $mr->program = $program;
            $mr->reel_id = $reelID;
            $mr->component_pn = $compPN;
            $mr->feed_time = $feedTime;
            $mr->reel_qty = $reelQTY;
            $mr->usage = $usage;
            $mr->target_qty = $targetQTY;
            $mr->sys_qty = $sysQTY;
            $mr->accuracy = $acc;
            $mr->mat_load_id = $matloadID;
            $mr->date = $date;
            $mr->save();
        }
    }
}
