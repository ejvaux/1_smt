<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PcbExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Division;
use App\Models\Pcb;
use App\Models\WorkOrder;

class ExportsController extends Controller
{
    public function index()
    {
        return view('pages.export.ep'/* ,compact() */);
    }
    public function exportpcb(Request $request)
    {
        $filename = 'PRIMA_';
        $qty = 0;
        $pcbs = Pcb::where('exported',0)->get();
        foreach ($pcbs as $pcb) {
            $wo = WorkOrder::where('ID',$pcb->jo_id)->pluck('SALES_ORDER')->first();
            if($wo != ''){
                $temp = $pcb;
                break;
            }
        }
        if($wo != ''){
            $qty = Pcb::where('jo_id',$temp->jo_id)->count();
            $filename .= Division::where('DIVISION_ID',$temp->division_id)->pluck('DIVISION_NAME')->first() . '_';
            if($wo == ''){
                $filename .= 'NoWorkOrder_';
            }
            else{
                $filename .= $wo.'_';
            }
            $filename .= Date('YmdHi').'_';
            $filename .= $qty;
            Pcb::where('jo_id',$temp->jo_id)->update(['exported'=> 1]);            
            Excel::store(new PcbExport($temp->jo_id), $filename.'.xlsx','export_test');
        }        
    }
}
