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

        $models=modelSMT::all();
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
        $today = Date('Y-m-d');
        $dt = Carbon::parse($today)->subday();
        $from = Carbon::parse($today)->subday()->addHours(6);
        $to = Carbon::parse($today)->addHours(6);
        /* $mat_loads = MatLoadModel::where('created_at','>=',$from)->where('created_at','<',$to)->count(); */
        $mat_loads = MatLoadModel::where('id',62229)->first();
        
        /* // Get total system quantity
        $reel = CustomFunctions::getQrData($mat_loads->ReelInfo,'RID');
        $total = 0;
        $serials = MatSnComp::select('id','mat_comp_id','sn','RID','model_id','component_id')->where('RID',$reel)->get();
        foreach ($serials as $serial) {            
            $total += count($serial->sn);
        }
        // End

        // Get Usage
        $u = Feeder::where('model_id',$mat_loads->model_id)
                ->where('line_id',$mat_loads->machine->line->linename->id)
                ->where('machine_type_id',$mat_loads->machine->machine_type_id)
                ->where('table_id',$mat_loads->table_id)
                ->where('mounter_id',$mat_loads->mounter_id)
                ->where('pos_id',$mat_loads->pos_id)
                ->max('usage'); 
        // End

        $line = $mat_loads->machine->line->linename->name;
        $pcbPN = $mat_loads->model->item_code;
        $program = $mat_loads->model->program_name;
        $reelID = $reel;
        $compPN = CustomFunctions::getQrData($mat_loads->ReelInfo,'PN');
        $feedTime = $mat_loads->created_at;
        $reelQTY = CustomFunctions::getQrData($mat_loads->ReelInfo,'QTY');
        $usage = $u;
        if ($usage) {
            $targetQTY = $reelQTY/$usage;
        }
        else{
            $targetQTY = $reelQTY;
        }
        $sysQTY = $total;
        $acc = round(($sysQTY/$targetQTY) * 100);
        $matloadID = $mat_loads->id;
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
            $rep->accuracy = $acc.'%';
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
            $mr->accuracy = $acc.'%';
            $mr->mat_load_id = $matloadID;
            $mr->date = $date;
            $mr->save();
        } */

        InsertMatRep::dispatch($mat_loads);
        /* return $reelID; */
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
