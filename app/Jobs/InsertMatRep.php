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
use App\MatLoadModel;

class InsertMatRep implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $matload;
    protected $date;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($matload,$date)
    {
        $this->matload = $matload;
        $this->date = $date;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /* $today = Date('Y-m-d'); */
        /* $dt = Carbon::parse($today)->subday(); */
        $dt = $this->date;

        // Get material Load
        
        $mload = MatLoadModel::where('id',$this->matload->id)->first();

            // Get total system quantity
            $_reel = CustomFunctions::getQrData($mload->ReelInfo,'RID');
            $_total = 0;
            $_serials = MatSnComp::where('RID',$_reel)->get();
            $_sns = [];
            foreach ($_serials as $_serial) {            
                foreach ($_serial->sn as $_s) {
                    $_sns[] = $_s;
                }
            }
            $_total = count(array_unique($_sns));
            // End

        $mt = MatLoadModel::where('id','<',$this->matload->id)
                                ->where('machine_id',$this->matload->machine_id)
                                ->where('model_id',$this->matload->model_id)
                                ->where('table_id',$this->matload->table_id)
                                ->where('mounter_id',$this->matload->mounter_id)
                                ->where('pos_id',$this->matload->pos_id)
                                ->orderBy('id','DESC');
        
        if($_total = 0){
            // Get 2nd previous material load
            $prev = $mt->skip(1)->first();
        }
        else{
            // Get previous material load
            $prev = $mt->first();
        }      

        if($prev){
            // Get total system quantity
            $reel = CustomFunctions::getQrData($prev->ReelInfo,'RID');
            $total = 0;
            $serials = MatSnComp::where('RID',$reel)->get();
            $sns = [];
            foreach ($serials as $serial) {            
                foreach ($serial->sn as $s) {
                    $sns[] = $s;
                }
            }
            $total = count(array_unique($sns));
            // End

            // Get Usage
            $u = Feeder::where('model_id',$prev->model_id)
                    ->where('line_id',$prev->machine->line->linename->id)
                    ->where('machine_type_id',$prev->machine->machine_type_id)
                    ->where('table_id',$prev->table_id)
                    ->where('mounter_id',$prev->mounter_id)
                    ->where('pos_id',$prev->pos_id)
                    ->max('usage'); 
            // End

            $line = $prev->machine->line->linename->name;
            if($prev->model->item_code){
                $pcbPN = $prev->model->item_code;
            }
            else{
                $pcbPN = '';
            }            
            $program = $prev->model->program_name;
            $reelID = $reel;
            $compPN = CustomFunctions::getQrData($prev->ReelInfo,'PN');
            $feedTime = $prev->created_at;
            $reelQTY = CustomFunctions::getQrData($prev->ReelInfo,'QTY');
            $usage = $u;
            $sysQTY = $total;
            $matloadID = $prev->id;
            $date = $dt;
            if ($usage != 0 || $usage > 0) {
                $targetQTY = $reelQTY/$usage;

                /* $rep = MaterialReport::where('mat_load_id',$matloadID)->where('reel_id',$reel)->first(); */
                $rep = MaterialReport::where('reel_id',$reel)->first();

                if(!$rep){
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
                    $mr->mat_load_id = $matloadID;
                    $mr->date = $date;
                    $mr->save();
                }
            }
           
            /* if($rep){
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
                $mr->mat_load_id = $matloadID;
                $mr->date = $date;
                $mr->save();
            } */
        }        
    }
}
