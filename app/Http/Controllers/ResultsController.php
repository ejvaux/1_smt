<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrder;
use App\Models\Pcb;
use App\Models\DivProcess;

class ResultsController extends Controller
{
    public function index(Request $request)
    {
        $dprocs = DivProcess::all();
        $wts = [];
        $woi = '';
        if($request->input('wo')){
            $woi = $request->input('wo');
            if(stripos($request->input('wo'), ',')){
                $wos = explode(",",$request->input('wo'));
            }
            else{
                $wos = explode(" ",$request->input('wo'));
            }
            foreach ($wos as $wo) {
                $total = 0;
                $jos = WorkOrder::where('SALES_ORDER',$wo)->get();
                foreach ($jos as $jo) {
                    $total += Pcb::where('jo_id',$jo->ID)->where('div_process_id',$request->input('pid'))->where('type',$request->input('type'))->whereNull('work_order')->count();
                }
                $total += Pcb::where('work_order',$wo)->where('div_process_id',$request->input('pid'))->where('type',$request->input('type'))->whereNotNull('work_order')->count();
                $wts[$wo] = $total;
                
            }
        }
        /* return dd($wts); */
        return view('pages.results.wo',compact('wts','dprocs','woi'));
    }
}
