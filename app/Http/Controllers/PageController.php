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

use App\Models\MatComp;
use App\Models\MatSnComp;
use App\Models\Pcb;

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

    public function testing(Request $request)
    {
        /* $joid = '38853';

        $string = \App\Models\WorkOrder::where('ID',$joid)->pluck('ITEM_CODE')->first();

        if($string[-1] == 'B' || $string[-1] == 'b'){
            echo 'BOTTOM';
        }
        else if($string[-1] == 'T'){
            echo 'TOP';
        }
        else {
            echo $string;
        } */
        return [
            'type' => 'success',
            'message' => $request->message,
            'message2' => $request->message2
        ];
    }

}
