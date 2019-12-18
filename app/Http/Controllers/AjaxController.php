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
use App\modelSMT;
use App\ErrorMatLoading;
use App\Exports\MaterialLoadExport;
use App\Exports\ScanRecordExport;
use App\Exports\ErrorExport;
use Response;
use App\Models\MaterialCount;
use App\Custom\CustomFunctions;
use App\Http\Controllers\MES\model\Modname;
use App\Http\Controllers\MES\model\Feeder;
use App\Http\Controllers\MES\model\Line;
use App\Http\Controllers\Api\ApiController;
use App\Models\MatComp;

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
                            ->where('serial_number','LIKE','%'.$request->input('sel_sn').'%')
                            ->where('updated_at','LIKE',$request->input('io_date').'%')
                            ->orwhere('created_at','LIKE',$request->input('io_date').'%');
                            

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
             //series -68 for SMT, 31 for INJ  where Status='R' AND Series = '31' AND StartDate = ?",[$pdate]);
        $pdate=$request->input('plandate');

        $data=SAPPlanModel::where('Series','68')
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

    public function CheckFeederList(Request $request) {
        $machine = $request->input('machine_id');
        $component = $request->input('new_PN');
        //$machine = "CM60201A";
        $m_code =substr($machine,0,-1);
        $table=substr($machine,-1);        
        
        $line_id = 0;
        $mach_type= machine::where('barcode',$m_code)->first();
        $table_id= tableSMT::where('name',$table)->first();
        $comp_id= component::where('product_number',$component)->first();        
        if($mach_type){
            $line_id = $mach_type->line->linename->id;
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
        $model = modelSMT::where('lines','LIKE','%"'.$line_id.'"%')->first();

        if(!isset($model)){
            return "NO RECORD";
        }
        
        $data=feeders::where('model_id',$model->id)
                    ->where('line_id',$line_id)
                    ->where('machine_type_id',$mach_type)
                    ->where('table_id',$table_id)
                    ->where('mounter_id',$request->input('feeder_slot'))
                    ->where('pos_id',$request->input('position'))
                    ->where('component_id',$comp_id)
                    ->first();
        
           /*  $data=feeders::where('machine_type_id',$mach_type)
                       ->where('table_id',$table_id)
                       ->where('model_id',$model_id)
                       ->where('mounter_id',$request->input('feeder_slot'))
                       ->where('pos_id',$request->input('position'))
                       ->where('component_id',$comp_id)
                       ->first(); */
        
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
        /* $m_code =substr($machine,0,7);
        $table=substr($machine,-1); */
        $m_code =substr($machine,0,-1);
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
        /* $m_code =substr($machine,0,7);
        $table=substr($machine,-1); */
        $m_code =substr($machine,0,-1);
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
        /* $m_code =substr($machine,0,7);
        $table=substr($machine,-1); */
        $m_code =substr($machine,0,-1);
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
                                ->orderby('mounter_id','ASC')
                                ->get();
       
        $machine = machine::with('machine_type_rel','line_rel')
                            ->get();

                            
        //return Response::json($data);        
        return Response::json(array('running'=>$data,'machine'=>$machine));         

    }

    public function LoadFeederRunningTable(Request $request){

        $mach_type= machine::where('id',$request->input('machine_id'))->first();
        $mach_type=$mach_type->machine_type_id;
        $data = feeders::with('component_rel','order_rel')
                        ->where('machine_type_id',$mach_type)
                        ->where('table_id',$request->input('table_id'))
                        ->where('pos_id',$request->input('position_id'))
                        ->where('mounter_id',$request->input('mounter_id'))
                        ->where('model_id',$request->input('model_id'))
                        ->get();
        
        return Response::json($data);
    }
    public function ScanEmpID(Request $request){
        $data=employee::where('pin',$request->input('empCode'))->get();

       /*  if($data){
            
            
        }
        else{
            $data = "no match";
        }
        return $data; */
        return Response::json($data);
    }

    public function ExportScanRecord(Request $request){
        return (new ScanRecordExport(
            $request->input('io_date'),
            $request->input('pline_sel'),
            $request->input('process_sel'),
            $request->input('machine_sel'),
            $request->input('bot_panel_input_scan')
        ))->download('Material History.xlsx');
    }

    public function AutoExportScanRecord(Request $request){

        $data = scanrecordlist::where('ExportStatus','!=','1')
                                ->groupBy('SapPlanID');

        foreach ($data as $workorder) {

        return (new ScanRecordExport(
            $workorder->SapPlanID
        ))->download('PRIMA_SMT_'.$workorder->SapJONum.'.xlsx');

        }
    }


    public function ErrorInsert(Request $request){
        $machine = $request->input('machine_id');
        $component = $request->input('new_PN');
        //$machine = "CM60201A";
        /* $m_code =substr($machine,0,7);
        $table=substr($machine,-1); */
        $m_code =substr($machine,0,-1);
        $table=substr($machine,-1);
        
        $mach_type= machine::where('barcode',$m_code)->first();
        $table_id= tableSMT::where('name',$table)->first();
        $comp_id= component::where('product_number',$component)->first();
        $model_id = modelSMT::where('code',$request->input('model_id'))->first();
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
        if($model_id){
            $model_id = $model_id->id;
        }
        else{
            $model_id = "0";
        }

        $insrecord=new ErrorMatLoading();
        $insrecord->machine_id=$mach_type;
        $insrecord->model_id=$request->input('model_id');
        $insrecord->table_id=$table_id;
        $insrecord->mounter_id=$request->input('feeder_slot');
        $insrecord->pos_id=$request->input('position');
        $insrecord->component_id=$comp_id;
        $insrecord->employee_id=$request->input('emp_id');
        $insrecord->ReelInfo=$request->input('reelInfo');
        $insrecord->ErrorType=$request->input('errorType');
        $insrecord->save();

    }

    public function LoadError(Request $request){

        $data=ErrorMatLoading::with('machine_rel','smt_model_rel','smt_table_rel','mounter_rel','smt_pos_rel','component_rel','order_rel','employee_rel')
        ->where('created_at', 'LIKE',$request->input('sdate').'%')
        ->orderby('created_at','DESC')
        ->get();

        
        return Response::json($data);
    }

    public function ExportError(Request $request){
        return (new ErrorExport(
            $request->input('s_date')
        ))->download('Error Logs.xlsx');
    }

    public function loadreplenish(Request $request)
    {
        $reps = [];
        $model = Modname::where('lines','LIKE','%"'.$request->input('line_id').'"%')->first();
        if($model){
            $feeders = Feeder::where('model_id',$model->id)
                            ->where('line_id',$request->input('line_id'))
                            ->where('table_id','!=',0)
                            ->groupBy('pos_id','mounter_id','table_id','machine_type_id')
                            ->orderBy('machine_type_id')
                            ->orderBy('table_id')
                            ->orderBy('mounter_id')
                            ->orderBy('pos_id')
                            ->get();

            foreach ($feeders as $feeder) {
                $lin = $feeder->machinetype->machine()->pluck('line_id');
                $mach = \App\Http\Controllers\MES\model\Line::whereIN('id',$lin)->where('line_name_id',$feeder->line_id)->pluck('machine_id')->first();
                $matload = MatLoadModel::where('model_id',$feeder->model_id)
                        ->where('machine_id',$mach)
                        ->where('table_id',$feeder->table_id)
                        ->where('mounter_id',$feeder->mounter_id)
                        ->where('pos_id',$feeder->pos_id)
                        ->latest('id')
                        ->first();

                if($matload){
                    $qty = CustomFunctions::getQrData($matload->ReelInfo,'QTY');
                    $rid = CustomFunctions::getQrData($matload->ReelInfo,'RID');
                    $total = 0;
                    $serials = \App\Models\MatSnComp::where('RID',$rid)->get();
                    $sns = [];
                    if($serials){
                        foreach ($serials as $serial) {            
                            foreach ($serial->sn as $s) {
                                $sns[] = $s;
                            }
                        }
                    }
                    $total = count(array_unique($sns));
                    $sqty = $total * $feeder->usage;
                    $rqty =  $qty - $sqty;
                    $bqty = $qty * 0.1;
                    if($rqty < $bqty){
                        $reps[] = [
                            "feeder_id" => $feeder->id,
                            "machine" => $feeder->machinetype->name,
                            "table" => $feeder->table_id,
                            "feeder" => $feeder->mounter->code,
                            "position" => $feeder->position->name,
                            "rqty" => $rqty,
                            "qty" => $qty
                        ];
                    }
                }
            }
        }        
        return view('includes.table.replenishTable', compact('reps'));
    }

    public function checkreplenish(Request $request)
    {
        if(CustomFunctions::getQrLength($request->input('qr')) > 12 || !CustomFunctions::getQrData($request->input('qr'),'RID')){
            return [
                'type' => 'error',
                'message' => 'Error processing Reel Qr Code. Please try again.'
            ];            
        }
        if (!$request->input('eid')) {
            return [
                'type' => 'error',
                'message' => 'Scan Employee first.'
            ];
        }
        $feeder = Feeder::find($request->input('id'));
        $pn = CustomFunctions::getQrData($request->input('qr'),'PN');
        $cid = component::where('product_number',$pn)->pluck('id')->first();
        $chck = feeders::where('model_id',$feeder->model_id)
                        ->where('line_id',$feeder->line_id)
                        ->where('machine_type_id',$feeder->machine_type_id)
                        ->where('table_id',$feeder->table_id)
                        ->where('mounter_id',$feeder->mounter_id)
                        ->where('pos_id',$feeder->pos_id)
                        ->where('component_id',$cid)
                        ->first();    
        if($chck){
            return $this->insertmatload($request,$chck);
            return [
                'type' => 'success',
                'message' => 'MERON'
            ];
        }
        else{
            return [
                'type' => 'error',
                'message' => 'Component not found in the feeder list. Please check your input data or the MODEL in Line Config.'
            ];
        }
        /* return [
            'type' => 'success',
            'message' => '"'.$cid.'"'
        ]; */
    }

    public function insertmatload($request,$chck)
    {
        $feeder = Feeder::find($request->input('id'));
        $rid = CustomFunctions::getQrData($request->input('qr'),'RID');        
        $pn = CustomFunctions::getQrData($request->input('qr'),'PN');
        $qty = CustomFunctions::getQrData($request->input('qr'),'QTY');
        $cid = component::where('product_number',$pn)->pluck('id')->first();

        // Input
        $mid = Line::where('line_name_id',$feeder->line_id)->pluck('machine_id');
        $machine = machine::where('machine_type_id',$feeder->machine_type_id)->whereIN('id',$mid)->first();
        $table = tableSMT::where('id',$feeder->table_id)->first();
        $mach_id = $machine->id;
        $model_id = $feeder->model_id;
        $table_id = $feeder->table_id;
        $mounter_id = $feeder->mounter_id;
        $pos_id = $feeder->pos_id;
        $component_id = $cid;
        $order_id = $chck->order_id;
        $employee_id = $request->input('eid');
        $ReelInfo = $request->input('qr');
        $scanmach = $machine->barcode.$table->name;
        
        // Check duplicate        
        $dup =  MatLoadModel::where('ReelInfo','LIKE',"%".$rid."%")
                            ->latest('id')
                            ->first();
        if($dup){
            if($dup->machine_id == $feeder->machine_type_id && $dup->table_id == $feeder->table_id && $dup->mounter_id == $feeder->mounter_id && $dup->pos_id == $feeder->pos_id){
                return [
                    'type' => 'error',
                    'message' => 'Reel Already Scanned.'
                ];
            }
        }

        // Insert Material
        $insrecord=new MatLoadModel();
        $insrecord->machine_id=$mach_id;
        $insrecord->model_id=$model_id;
        $insrecord->table_id=$table_id;
        $insrecord->mounter_id=$mounter_id;
        $insrecord->pos_id=$pos_id;
        $insrecord->component_id=$component_id;
        $insrecord->order_id=$order_id;
        $insrecord->employee_id=$employee_id;
        $insrecord->ReelInfo=$ReelInfo;
        $insrecord->results="MATCH";
        
        $req = [
            'machine_id' => $scanmach,
            'new_PN' => $pn,
            'position' => $pos_id,
            'feeder_slot' => $mounter_id,
            'comp_rid' => $rid,
            'comp_qty' => $qty,
            'model_id' => $model_id
        ];
        $matcomp_id = ApiController::insertmatcomp1($req);
        if($matcomp_id){
            $insrecord->save();
            $mc = MatComp::find($matcomp_id);
            $mc->mat_load_id = $insrecord->id;
            $mt = $mc->materials;
            foreach ($mt as $key => $value) {
                if(
                    strtoupper($value['machine']) == strtoupper($req['machine_id']) && 
                    $value['position'] == $req['position'] && 
                    $value['feeder'] == $req['feeder_slot']
                    )
                {
                    $mt[$key]['matload_id'] = $insrecord->id;
                }
            }
            $mc->materials = $mt;
            $mc->save();
        }
        else{
            return [
                'type' => 'error',
                'message' => 'Error Inserting Component. Please Contact MIS Support.'
            ];
        }

        $running_mach = RunningOnMachine::where('machine_id',$mach_id)
                                        ->where('model_id',$model_id)
                                        ->where('table_id',$table_id)
                                        ->where('mounter_id',$mounter_id)
                                        ->where('pos_id',$pos_id)
                                        ->first(); 

        if($running_mach){            
            $RunUpdate = RunningOnMachine::find($running_mach->id);
            $RunUpdate->machine_id=$mach_id;
            $RunUpdate->model_id=$model_id;
            $RunUpdate->table_id=$table_id;
            $RunUpdate->mounter_id=$mounter_id;
            $RunUpdate->pos_id=$pos_id;
            $RunUpdate->component_id=$component_id;
            $RunUpdate->order_id=$order_id;
            $RunUpdate->employee_id=$employee_id;
            $RunUpdate->datetime_update= date("Y-m-d");
            $RunUpdate->save();
        }
        else{
            $RunInsert=new RunningOnMachine();
            $RunInsert->machine_id=$mach_id;
            $RunInsert->model_id=$model_id;
            $RunInsert->table_id=$table_id;
            $RunInsert->mounter_id=$mounter_id;
            $RunInsert->pos_id=$pos_id;
            $RunInsert->component_id=$component_id;
            $RunInsert->order_id=$order_id;
            $RunInsert->employee_id=$employee_id;
            $RunInsert->datetime_update= date("Y-m-d");
            $RunInsert->save();
        }
        return [
            'type' => 'success',
            'message' => 'Data Recorded!: All inputs are correct.'
        ];
    }

}
