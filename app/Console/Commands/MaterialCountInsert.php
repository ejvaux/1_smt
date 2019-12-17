<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\MES\model\Modname;
use App\Http\Controllers\MES\model\Feeder;
use App\MatLoadModel;
use App\Custom\CustomFunctions;

class MaterialCountInsert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'material:count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Counting of reel quantity';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        for ($i=0; $i < 59; $i++) {
            $fid = [];
            $models = Modname::where('lines','<>','[]')->get();
            foreach ($models as $model) {
                foreach ($model->lines as $line) {
                    $feeders = Feeder::where('model_id',$model->id)
                                ->where('line_id',$line)
                                ->where('table_id','!=',0)
                                ->groupBy('pos_id','mounter_id','table_id','machine_type_id')
                                ->orderBy('machine_type_id')
                                ->orderBy('table_id')
                                ->orderBy('mounter_id')
                                ->orderBy('pos_id')
                                ->get();
                    /* $fid = []; */
                    foreach ($feeders as $feeder) {
                        $lin = $feeder->machinetype->machine()->pluck('line_id');
                        $mach = \App\Http\Controllers\MES\model\Line::whereIN('id',$lin)->where('line_name_id',$feeder->line_id)->pluck('machine_id')->first();
                        $matload = MatLoadModel::where('model_id',$feeder->model_id)
                                ->where('machine_id',$mach)
                                ->where('table_id',$feeder->table_id)
                                ->where('mounter_id',$feeder->mounter_id)
                                ->where('pos_id',$feeder->pos_id)
                                ->latest('id')
                                ->first();
                        $mat_count = \App\Models\MaterialCount::where('model_id',$model->id)->where('line_id',$line)->where('feeder_id',$feeder->id)->first();
                        if (!$mat_count) {
                            $mat_count = new \App\Models\MaterialCount;
                            $mat_count->model_id = $model->id;
                            $mat_count->line_id = $line;
                            $mat_count->feeder_id = $feeder->id;
                            $mat_count->save();
                        }
                        if ($matload) {
                            $rid = CustomFunctions::getQrData($matload->ReelInfo,'RID');
                            $qty = CustomFunctions::getQrData($matload->ReelInfo,'QTY');
                            $total = 0;
                            $serials = \App\Models\MatSnComp::where('RID',$rid)->get();
                            $sns = [];
                            if($serials){
                                foreach ($serials as $serial) {            
                                    foreach ($serial->sn as $s) {
                                        $sns[] = $s;
                                    }
                                }
                            }
                            $total = count(array_unique($sns));
                            $mat_count->mat_load_id = $matload->id;
                            $mat_count->usage = $feeder->usage;
                            $mat_count->reel_qty = $qty;
                            $mat_count->sn = $total;
                            $mat_count->remaining_qty = $qty - $total * $feeder->usage;
                            $mat_count->save();
                        }
                        else{
                            $mat_count->mat_load_id = null;
                            $mat_count->usage = null;
                            $mat_count->reel_qty = null;
                            $mat_count->sn = null;
                            $mat_count->remaining_qty = null;
                            $mat_count->save();
                        }
                        $fid[] = $feeder->id;
                    }
                    /* \App\Models\MaterialCount::whereNotIn('feeder_id',$fid)->delete(); */
                }
            }
            sleep(5);
            \App\Models\MaterialCount::whereNotIn('feeder_id',$fid)->delete();
        }                
    }
}
