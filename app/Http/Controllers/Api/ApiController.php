<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MES\model\Employee;
use App\Http\Controllers\MES\model\LineName;
use App\Models\DivProcess;
use App\Models\WorkOrder;

class ApiController extends Controller
{
    public function scanpinemp(Request $request)
    {
        if($request->input('check') == 1){
            if($name = Employee::where('pin',$request->input('pin'))->first())
            {
                return $name;
            }
            else{
                return 0;
            }
        }
        elseif($request->input('check') == 2){
            if($name = Employee::where('pin',$request->input('pin'))->where('repair',1)->first())
            {
                return $name;
            }
            else{
                return 0;
            }
        }        
    }
    public function divprocesses($id)
    {
        return DivProcess::where('division_id',$id)->get();
    }
    public function linenames($id)
    {
        return LineName::where('division_id',$id)->get();
    }
    public function loadWOtable(Request $request)
    {
        $workorders = WorkOrder::where('JOB_ORDER_NO','LIKE',"{$request->input('div')}%")->where('DATE_',$request->input('dte'))->paginate('100');
        return view('includes.table.spTable',compact('workorders'));
    }
}
