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
use App\feeders;
use App\machine;
use App\tableSMT;
use App\component;
use App\MatLoadModel;
use App\RunningOnMachine;
use App\mounter;
use App\Exports\MaterialLoadExport;
use Response;

class AjaxController extends Controller
{
    //
   
    public function errorcode(){
        $error_code = errorcodelist::all();
        /* Response::json($error_code); */
        /*   return $error_code; */
        
        return response()->json([$error_code]);
    }

    public function checkRecord(Request $request){
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

    public function LoadDataToTable(Request $request){
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

    public function SAPLoadDataToTable(Request $request){
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

    public function TotalPerJO(Request $request){
        $pid=$request->input('pid');
        $data=scanrecordlist::where('SapPlanID','19900')
                            ->get();

        //return Response::json($data);
       
       return ("lala");
    }

    public function checkPINemployee(Request $request){
        $data=employee::where('id',$request->input('empid'))->get();
        return Response::json($data);
    }

    public function CheckFeederList(Request $request)
    {
        $machine = $request->input('machine_id');
        $component = $request->input('new_PN');
        //$machine = "CM60201A";
        $m_code =substr($machine,0,7);
        $table=substr($machine,-1);
        
        $mach_type= machine::where('barcode',$m_code)->first();
        $table_id= tableSMT::where('name',$table)->first();
        $comp_id= component::where('product_number',$component)->first();

        if($mach_type){
            $mach_type=$mach_type->machine_type_id;
        }
        else{
            $mach_type = "0";
        }
        if($table_id){
            $table_id=$table_id->id;
        }
        else{
            $table_id = "0";
        }
        if($comp_id){
            $comp_id=$comp_id->id;
        }
        else{
            $comp_id = "0";
        }
        
        $data=feeders::where('machine_type_id',$mach_type)
                       ->where('table_id',$table_id)
                       ->where('model_id',$request->input('model_id'))
                       ->where('mounter_id',$request->input('feeder_slot'))
                       ->where('pos_id',$request->input('position'))
                       ->where('component_id',$comp_id)
                       ->first();
        
        if ($data) {
            return $data->order_id;
        }
        else{
            return "NO RECORD";
        }
                

    }

    public function LoadDetailsPanel(Request $request){
        $machine = $request->input('machine_id');
        $component = $request->input('new_PN');
        $m_code =substr($machine,0,7);
        $table=substr($machine,-1);
        
        $mach_type= machine::where('barcode',$m_code)->first();
        $table_id= tableSMT::where('name',$table)->first();
        $comp_id= component::where('product_number',$component)->first();

        $data=feeders::with('machine_type_rel','smt_model_rel','smt_table_rel','mounter_rel','smt_pos_rel','component_rel','order_rel')
                        ->where('machine_type_id',$mach_type->id)
                        ->where('model_id',$request->input('model_id'))
                        ->orderby('table_id','ASC')
                        ->orderby('pos_id','ASC')
                        ->orderby('order_id','ASC')
                        ->get();


        $data2= DB::connection('mysql2')
                    ->select("SELECT table_id,mounter_id,count(mounter_id) as res from smt_feeders WHERE machine_type_id = ? AND model_id = ?  GROUP BY table_id,mounter_id",[$mach_type->id,$request->input('model_id'),'1']);
        //return Response::json($data);


        return Response::json(array('feedlist'=>$data,'feedcount'=>$data2));
    }

    public function LoadHistoryTable(Request $request){
        $machine = $request->input('machine_id');
        $component = $request->input('new_PN');
        $m_code =substr($machine,0,7);
        $table=substr($machine,-1);
        
        $mach_type= machine::where('barcode',$m_code)->first();
        $table_id= tableSMT::where('name',$table)->first();
        $comp_id= component::where('product_number',$component)->first();

        $data=MatLoadModel::with('machine_rel','smt_model_rel','smt_table_rel','mounter_rel','smt_pos_rel','component_rel','order_rel','employee_rel')
                        ->where('created_at', 'LIKE',$request->input('sdate').'%')
                        ->orderby('created_at','DESC')
                        ->get();

        return Response::json($data);
    }

    
    public function CheckRunningTable(Request $request){
        $machine = $request->input('machine_id');
        $component = $request->input('new_PN');
        //$machine = "CM60201A";
        $m_code =substr($machine,0,7);
        $table=substr($machine,-1);
        
        $mach_type= machine::where('barcode',$m_code)->first();
        $table_id= tableSMT::where('name',$table)->first();
        $comp_id= component::where('product_number',$component)->first();

        if($mach_type){
            $mach_type=$mach_type->id;
        }
        else{
            $mach_type = "0";
        }
        if($table_id){
            $table_id=$table_id->id;
        }
        else{
            $table_id = "0";
        }
        if($comp_id){
            $comp_id=$comp_id->id;
        }
        else{
            $comp_id = "0";
        }

            
        $running_mach = RunningOnMachine::where('machine_id',$mach_type)
                                    ->where('table_id',$table_id)
                                    ->where('mounter_id',$request->input('feeder_slot'))
                                    ->where('pos_id',$request->input('position'))
                                    ->where('component_id',$comp_id)
                                    ->first();

        if($running_mach){
            return "update";
        }
        else{
            return "not match in running";
        }

    }

    public function ExportMatHistory(Request $request){
        return (new MaterialLoadExport($request->input('s_date')))->download('Material History.xlsx');
    }

    public function LoadRunningTbl(Request $request){

        $data = RunningOnMachine::with('machine_rel','smt_model_rel','smt_table_rel','mounter_rel','smt_pos_rel','component_rel','order_rel','employee_rel')
                                ->where('created_at','LIKE',$request->input('today').'%')
                                ->orwhere('updated_at','LIKE',$request->input('today').'%')
                                ->orderby('machine_id','ASC')
                                ->orderby('table_id','ASC')
                                ->orderby('pos_id','ASC')
                                ->get();
        $mounter = mounter::orderby('id','ASC')->get();
        $machine = machine::with('machine_type_rel','line_rel')
                            ->get();
        //return Response::json($data);        
        return Response::json(array('running'=>$data,'mounter'=>$mounter,'machine'=>$machine));         

    }
}
