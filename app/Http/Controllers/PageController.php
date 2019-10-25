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
        try {
            $pcbs = Pcb::where('created_at','<=',Carbon::parse(Date('Y-m-d'))->subMonth())->limit(5)->get();
            /* $n = 0;
            foreach ($pcbs as $pcb) {
                $id = $pcb->id;
                $ins = $pcb->toArray();
                PcbArchive::insert($ins);
                Pcb::where('id',$id)->delete();
                $n++;
            } */            
        } catch (\Throwable $th) {
            Log::channel('single')->error("[PCB ARCHIVING] ".$th);
        }
        /* return 'good'; */
        /* return $ins; */
        /* return PcbArchive::where('id',$id)->get(); */
        return $pcbs;
    }

}
