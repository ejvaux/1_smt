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

        $models=modelSMT::where('version','!=',0)->get();
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
        /* $f = MatComp::where('line_id', 17)->latest('id')->first();
        // return count($f->materials);
        return $f; */

        $f = MatLoadModel::where('model_id',24)->groupBy('machine_id','table_id','mounter_id','pos_id')->orderBy('id','DESC')->get();
        $page = "<table>";

        foreach ($f as $value) {
            $page .= "<tr>";
            $page .= "<td>". $value ."</td>";
            $page .= "</tr>";
        }

        $page .= "<table>";
        return $f->count();
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
