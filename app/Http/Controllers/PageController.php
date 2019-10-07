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
use App\Models\PcbArchive;
use App\Models\WorkOrder;
use App\Custom\CustomFunctions;

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
        /* $pcbs = \App\Models\Pcb::where('division_id',2)
                ->where('type',1)
                ->where('defect',0)
                ->where('RESULT','NG')
                ->whereNull('work_order')
                ->get();
        $count = 0;
        foreach ($pcbs as $pcb) {
            $wo = \App\Models\WorkOrder::where('ID',$pcb->jo_id)->pluck('SALES_ORDER')->first();
            Pcb::where('id',$pcb->id)->update(['work_order'=> $wo]);
            $count++;
        }

        return $count.' UPDATED.'; */
        $rid = '00FK19070701325';
        $cid = MatSnComp::where('RID',$rid)->pluck('component_id')->first();
        $pn = Component::where('id',$cid)->pluck('product_number')->first();
        $total = 1;
        $pcbs = [];
        $serials = MatSnComp::select('mat_comp_id','sn','RID','model_id','component_id')->where('RID',$rid)/* ->skip(5) *//* ->take(10) */->get();
        foreach ($serials as $serial) {
            $matcomp = Matcomp::where('id',$serial->mat_comp_id)->pluck('materials')->first();
            foreach ($matcomp as $cmp => $prop) {
                if($cmp == $serial->component_id){
                    $mach = $prop['machine'];
                    $fdr = $prop['feeder'];
                    $pos = LRPosition::where('id',$prop['position'])->pluck('name')->first();
                    break;
                }
            }
            /* $total += Pcb::where('mat_comp_id',$serial->mat_comp_id)->count('id');
            $total += PcbArchive::where('mat_comp_id',$serial->mat_comp_id)->count('id'); */
            /* $pcb1 = Pcb::select('id')->where('mat_comp_id',$serial->mat_comp_id)->get();
            $pcb2 = PcbArchive::select('id')->where('mat_comp_id',$serial->mat_comp_id)->get(); */
            /* $pcbs = $pcb1->merge($pcb2); */
            /* $pcbs = $pcb1->merge($pcbs);
            $pcbs = $pcb2->merge($pcbs); */
            $prog = modelSMT::where('id',$serial->model_id)->pluck('program_name')->first();            
            foreach ($serial->sn as $key) {
                $pcb = Pcb::where('serial_number',$key)->where('mat_comp_id',$serial->mat_comp_id)->first();
                if(!$pcb){
                    $pcb = PcbArchive::where('serial_number',$key)->where('mat_comp_id',$serial->mat_comp_id)->first();
                }
                if($pcb){                    
                    if(!$pcb->work_order){
                        $wo = WorkOrder::where('ID',$pcb->jo_id)->pluck('SALES_ORDER')->first();
                    }
                    else{
                        $wo = $pcb->work_order;
                    }
                    $pcbs[] = [
                        'wo' => $wo,
                        'sn' => $pcb->serial_number,
                        'rid' => $serial->RID,
                        'pn' => $pn,
                        'dt' => $pcb->created_at,
                        'prog' => $prog,
                        'mach' => CustomFunctions::getmachcode($mach),
                        'tb' => CustomFunctions::getmachtable($mach),
                        'fdr' => $fdr,
                        'pos' => $pos,
                        'jo' => $pcb->jo_number,
                        'emp' => $pcb->employee->fname . ' ' . $pcb->employee->lname
                    ];
                }                
            }
        }
        return count($pcbs);
    }

}
