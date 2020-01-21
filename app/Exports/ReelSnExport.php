<?php

namespace App\Exports;

use App\Models\MatSnComp;
use App\Models\MatSnCompsArchive;
use App\Models\MatComp;
use App\Models\Pcb;
use App\Models\PcbArchive;
use App\Models\WorkOrder;
use App\Custom\CustomFunctions;
use App\Http\Controllers\MES\model\Component;
use App\Http\Controllers\MES\model\Position;
use App\Http\Controllers\MES\model\Modname;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class ReelSnExport implements FromView, WithTitle
{
    public function __construct($rid)
    {
        $this->rid = $rid;
    }   

    public function view(): View
    {
        $rid = $reel = $this->rid;
        /* $cid = MatSnComp::where('RID',$rid)->pluck('component_id')->first(); */
        $archive = MatSnCompsArchive::where('RID',$rid);
        $cid = MatSnComp::where('RID',$rid)
                        ->union($archive)
                        ->first()->component_id;
        $pn = Component::where('id',$cid)->pluck('product_number')->first();
        $pcbs = [];
        /* $serials = MatSnComp::where('RID',$rid)->get(); */
        $archive1 = MatSnCompsArchive::where('RID',$rid);
        $serials = MatSnComp::where('RID',$rid)
                        ->union($archive1)
                        ->get();
        foreach ($serials as $serial) {
            $matcomp = Matcomp::where('id',$serial->mat_comp_id)->pluck('materials')->first();
            foreach ($matcomp as $cmp => $prop) {
                /* if($cmp == $serial->component_id){ */
                if($prop['component_id'] == $serial->component_id){
                    $mach = $prop['machine'];
                    $fdr = $prop['feeder'];
                    $pos = Position::where('id',$prop['position'])->pluck('name')->first();
                    break;
                }
            }
            $prog = Modname::where('id',$serial->model_id)->pluck('program_name')->first();            
            foreach ($serial->sn as $key) {
                $pcb = Pcb::where('serial_number',$key)->where('line_id',$serial->line_id)->first();
                if(!$pcb){
                    $pcb = PcbArchive::where('serial_number',$key)->where('line_id',$serial->line_id)->first();
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
        return view('includes.table.reelTableExport', compact('pcbs'));
    }

    public function title(): string
    {
        return 'Sheet1';
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    /* public function collection()
    {
        //
    } */
}
