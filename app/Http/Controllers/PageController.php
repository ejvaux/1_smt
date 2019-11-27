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
        $this->sn = 'M.CK296P0040';
        $mat_comp1 = MatComp::where('id',18);
        if($mat_comp1->first()){
            $mat_comp = $mat_comp1->first();
            foreach ($mat_comp->materials as $key => $value) {
                $cid = '';
                if(isset($value['component_id'])){
                    $cid = $value['component_id'];
                }
                else{
                    $cid = $key;
                }
                /* $comp = MatSnComp::where('mat_comp_id',$mat_comp->id)->where('component_id',$key)->where('RID',$value['RID'])->OrderBy('id','DESC')->first(); */
                $comp = MatSnComp::where('mat_comp_id',$mat_comp->id)
                                ->where('component_id',$cid)
                                ->where('RID',$value['RID'])
                                ->OrderBy('id','DESC')
                                ->first();
                if($comp){                                
                    $cc = $comp->sn;
                    if(count($comp->sn) > 499){
                        $c = new MatSnComp;
                        $c->model_id = $mat_comp->model_id;
                        $c->line_id = $mat_comp->line_id;
                        $c->mat_comp_id = $mat_comp->id;
                        $c->component_id = $cid;
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
                    $c->component_id = $cid;
                    $c->RID = $value['RID'];
                    $c->sn = array($this->sn);
                    $c->save();
                }
            }
        }
        else{
            return 'wala';
        }
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
