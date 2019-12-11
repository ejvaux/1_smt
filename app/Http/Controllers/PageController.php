<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ProdLine;
use App\ProcessList;
use App\errorcodelist;
use App\modelSMT;
use App\LRPosition;
use App\mounter;
use App\employee;
use App\machine;
use App\lineSMT;
use App\Http\Controllers\MES\model\LineName;
use App\Http\Controllers\MES\model\Component;
use Carbon\Carbon;
use App\Models\MatComp;
use App\Models\MatSnComp;
use App\Models\Pcb;
use App\Models\PcbArchive;
use App\Models\WorkOrder;
use App\Custom\CustomFunctions;
use App\Notifications\PcbDataExport;
use Notification;
use Illuminate\Support\Facades\Log;

// Testing
use App\MatLoadModel;
use App\Jobs\InsertMatRep;
use App\Http\Controllers\MES\model\Feeder;
use App\Http\Controllers\MES\model\Modname;
use App\Models\MaterialReport;

class PageController extends Controller
{
    //
    public function scan(){

        $pline=ProdLine::all();
        $processlist=ProcessList::all();
        $ecode=errorcodelist::all();
        $data="";

        return view('pages.scan.scanpage',compact('pline','processlist','ecode','data'));
    }


    public function mscan(){

        $models=modelSMT::all();
        $position=LRPosition::all();
        $mounter=mounter::all();
        $emp=employee::all();
        $mounters=mounter::all();
        $machine=machine::all();
        $line=lineSMT::all();
        $data="";

        return view('pages.materials.mscan',compact('models','position','mounter','emp','mounters','machine','line'));
    }
    public function mscan2(){

        $models=modelSMT::where('lines','!=',"[]")->get();
        $position=LRPosition::all();
        $mounter=mounter::all();
        $emp=employee::all();
        $mounters=mounter::all();
        $machine=machine::all();
        $line=lineSMT::all();
        $lines2 = LineName::orderBy('division_id')->get();
        $data="";

        return view('pages.materials.mscan2',compact(
            'models',
            'position',
            'mounter',
            'emp',
            'mounters',
            'machine',
            'line',
            'lines2'
        ));
    }

    public function errorlogs(){

        $models=modelSMT::all();
        $position=LRPosition::all();
        $mounter=mounter::all();
        $emp=employee::all();
        $mounters=mounter::all();
        $machine=machine::all();
        $line=lineSMT::all();
        $data="";

        return view('pages.materials.errorlogs',compact('models','position','mounter','emp','mounters','machine','line'));
    }

    public function testing()
    {
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
                }
            }
        }
        return $mat_count;
    }
    public function qrgen()
    {
        return \QrCode::size(200)
                /* ->format('png') */
                ->generate('
                The first argument passed to the select method is the raw SQL query, while the second argument is any parameter bindings that need to be bound to the query. Typically, these are the values of the where clause constraints. Parameter binding provides protection against SQL injection.
                ');
    }

}
