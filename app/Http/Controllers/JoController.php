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
                $jos = WorkOrder::where('SALES_ORDER',$w->WORK_ORDER)->get();
            }
        }
        else{
            $jos = WorkOrder::where('DATE_',Date('Y-m-d'))->get();
        }
        return view('pages.jo.jo',compact('jos'));
    }
}
