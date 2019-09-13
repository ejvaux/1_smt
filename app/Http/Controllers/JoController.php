<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrder;
use App\Models\WoSn;
use App\Models\Pcb;

class JoController extends Controller
{
    public function index(Request $request)
    {
        $t = $request->input('text');
        $wo = '';
        if($request->input('date') != ''){
            $date = $request->input('date');
        }
        else{
            $date = Date('Y-m-d');
        }
        if($t){
            $w = WoSn::where('SERIAL_NUMBER',$t)->first();
            if($w){
                $wo = $w->WORK_ORDER;
                $jos = WorkOrder::where('SALES_ORDER',$w->WORK_ORDER)->orderby('MACHINE_CODE')->get();
            }
            else{
                $jos = [];
            }
        }
        else{
            $jos = WorkOrder::where('DATE_',$date)
                ->where(function ($query) {
                    $query->where('JOB_ORDER_NO','LIKE','2%')
                    ->orwhere('JOB_ORDER_NO','LIKE','8%');
                })
                ->orderby('MACHINE_CODE')->get();
        }
        return view('pages.jo.jo',compact('jos','date','wo'));
    }
    public function getJOqty(Request $request)
    {
        $joid = $request->input('joid');
        $qty = WorkOrder::where('ID',$joid)->pluck('PLAN_QTY')->first();
        $aqty = Pcb::where('jo_id',$joid)->where('type',1)->count();
        $rqty = $qty - $aqty;
        return [
            'type' => 'success',
            'actual' => $aqty,
            'remaining' => $rqty
        ];
    }
}
