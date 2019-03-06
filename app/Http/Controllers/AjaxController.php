<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\errorcodelist;
use App\scanrecordlist;
use App\ProdLine;
use App\ProcessList;
use App\SAPPlanModel;
use App\employee;
use Response;

class AjaxController extends Controller
{
    //
   
    public function errorcode()
    {
        $error_code = errorcodelist::all();
        /* Response::json($error_code); */
        /*   return $error_code; */
        
        return response()->json([$error_code]);
    }

    public function checkRecord(Request $request)
    {
        $IDtoUpdate = scanrecordlist::where('prodline_id','=',$request->input('sel_prodline'))
        ->where('process_id','=',$request->input('sel_process'))
        ->where('serial_number','=',$request->input('serialnum')) 
        ->first();
       
        if ($IDtoUpdate) {
            return "HAS RECORD-".$IDtoUpdate->scan_result;
         }
         else{
             return "NO RECORD";
         }
        
    }

    public function LoadDataToTable(Request $request)
    {
        $prodline=$request->input('sel_prodline');
        $processline=$request->input('sel_process');
        $machineline=$request->input('sel_machine');
        
        $pline=ProdLine::all();
        $processlist=ProcessList::all();
        $ecode=errorcodelist::all();
        $data=scanrecordlist::with('userlink','errorlink','prodlinelink','processlink','machinelink')
                            ->where('scan_type',$request->input('sel_scaninput'))
                            ->where('serial_number','LIKE','%'.$request->input('sel_sn').'%');

        if($prodline!=""){
          $data=$data->where('prodline_id',$request->input('sel_prodline'));
        }
        if($processline!=""){
            $data=$data->where('process_id',$request->input('sel_process'));
        }
        if($machineline!=""){
            $data=$data->where('machine_id',$request->input('sel_machine'));
        }
        $data=$data->get();          
        return Response::json($data);
       // return($data);
      
    }

    public function SAPLoadDataToTable(Request $request)
    {
             //series -68 for SMT  where Status='R' AND Series = '31' AND StartDate = ?",[$pdate]);
        $pdate=$request->input('plandate');

        $data=SAPPlanModel::where('Series','31')
                            ->where('StartDate',$pdate)
                            ->where('Status','R')
                            ->where($request->input('s_field'),'LIKE','%'.$request->input('searchbox').'%')
                            ->get();

       /*  $data1= DB::connection('sqlsrv')
                    ->select("SELECT * from OWOR where Status='R' AND Series = '31' AND StartDate = ?",[$pdate]); */
        $data2= DB::connection('mysql')
                    ->select("SELECT SapPlanID,count(SapPlanID) as res from scanrecord GROUP BY SapPlanID");

        //$data3 = $data1->union($data2)->get();

        return Response::json(array('sap_plan'=>$data,'smt_result'=>$data2));
    }

    public function TotalPerJO(Request $request)
    {
        $pid=$request->input('pid');
        $data=scanrecordlist::where('SapPlanID','19900')
                            ->get();

        //return Response::json($data);
       
       return ("lala");
    }

    public function checkPINemployee(Request $request)
    {
        $data=employee::where('id',$request->input('empid'))->get();
        return Response::json($data);
    }
}
