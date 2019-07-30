<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrder;
use App\Models\WoSn;

class JoController extends Controller
{
    public function index(Request $request)
    {
        $t = $request->input('text');
        if($t){
            $w = WoSn::where('SERIAL_NUMBER',$t)->first();
            if($w){
                $jos = WorkOrder::where('SALES_ORDER',$w->WORK_ORDER)->orderby('MACHINE_CODE')->get();
            }
            else{
                $jos = [];
            }
        }
        else{
            $jos = WorkOrder::where('DATE_',Date('Y-m-d'))
                ->where(function ($query) {
                    $query->where('JOB_ORDER_NO','LIKE','2%')
                    ->orwhere('JOB_ORDER_NO','LIKE','8%');
                })
                ->orderby('MACHINE_CODE')->get();
        }
        return view('pages.jo.jo',compact('jos'));
    }
}
