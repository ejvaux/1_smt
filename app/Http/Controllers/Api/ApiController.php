<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MES\model\Employee;
use App\Http\Controllers\MES\model\LineName;
use App\Models\DivProcess;
use App\Models\WorkOrder;
use App\Models\Pcb;
use App\Models\Division;
use App\Custom\CustomFunctions;

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
        $workorders = WorkOrder::where('JOB_ORDER_NO','LIKE',"{$request->input('div')}%")->where('DATE_',$request->input('dte'))->orderBy('MACHINE_CODE')->get();
        return view('includes.table.spTable',compact('workorders'));
    }
    public function loadpcbtable(Request $request)
    {
        if($request->input('sn')){
            $pcbs = Pcb::where('serial_number',$request->input('sn'))->orderBy('id','DESC')->get();
        }
        else{
            $pcbs = Pcb::where('jo_id',$request->input('jo_id'))->where('div_process_id',$request->input('proc'))->where('type',$request->input('type'))->orderBy('id','DESC')->paginate(200);
        }        
        return view('includes.table.pcbTable',compact('pcbs'));
    }

    /* ---------------------- PCB SCANNING -------------------------- */

    public function scantype(Request $request)
    {
        if($request->type == 0){
            return $this->scanIn($request);
        }
        else if($request->type == 1){
            return $this->scanOut($request);
        }
        else{
            return [
                'type' => 'error',
                'message' => 'Scan Failed. Scan type not allowed.'
            ];
        }
        return [
            'type' => 'error',
            'message' => 'API ERROR: scantype'
        ];
    }

    /* --------------- INPUT SCANNING ------------------- */

    public function scanIn($request)
    {
        /* CHECKING FOR BOTTOM */
        if($request->division_id == 2 && $request->div_process_id == 2 ){
            $sn = Pcb::where('serial_number',$request->serial_number)->where('div_process_id',1)->where('type',1);
            if($sn->first()){
                return $this->checkdupIn($request);
            }
            else{
                return [
                    'type' => 'error',
                    'message' => 'Serial Number has no record on Bottom process.'
                ];
            }
        }
        else{
            return $this->checkdupIn($request);
        }
        return [
            'type' => 'error',
            'message' => 'API ERROR: scanIn'
        ];
    }
    public function checkdupIn($request)
    {
        $out = Pcb::where('serial_number',$request->serial_number)
        ->where('div_process_id',$request->div_process_id)
        ->where('type',1)
        ->first();

        $in = Pcb::where('serial_number',$request->serial_number)
            ->where('jo_id',$request->jo_id)
            ->where('div_process_id',$request->div_process_id)
            ->where('type',0)
            ->first();

        if(!$out){  
            if(!$in){
                return $this->checkjoquantity2($request);
            }
            else{
                return [
                    'type' => 'error',
                    'message' => 'Serial number already scanned IN.'
                ];
            }
        }
        else{
            return [
                'type' => 'error',
                'message' => 'Serial number already processed in ' . $out->divprocess->name . '.'
            ];
        }
        return [
            'type' => 'error',
            'message' => 'API ERROR: checkdupIn'
        ];
    }    

    /* ------------- OUTPUT SCANNING ------------------- */

    public function scanOut($request)
    {
        /* CHECK FOR INPUT */
        $sn = Pcb::where('serial_number',$request->serial_number)
                ->where('jo_id',$request->jo_id)
                ->where('div_process_id',$request->div_process_id)
                ->where('type',0);        

        if($sn->first()){
            $sn = $sn->first();
            if($sn->defect == 1){
                return [
                    'type' => 'error',
                    'message' => 'Scan Failed. PCB has defect.'
                ];
            }
            else{                
                return $this->checkdupOut($request);               
            }       
        }
        else{
            return [
                'type' => 'error',
                'message' => 'Serial Number has no INPUT record.'
            ];
        }
        return [
            'type' => 'error',
            'message' => 'API ERROR: scanOut'
        ];
    }
    public function checkdupOut($request)
    {
        $out = Pcb::where('serial_number',$request->serial_number)
            ->where('jo_id',$request->jo_id)
            ->where('div_process_id',$request->div_process_id)
            ->where('type',1)
            ->first();

        if(!$out){  
            return $this->checkjoquantity2($request);
        }
        else{
            return [
                'type' => 'error',
                'message' => 'Serial number already scanned out.'
            ];
        }
        return [
            'type' => 'error',
            'message' => 'API ERROR: checkdupIn'
        ];
    }

    /* --------------------------------------------------------------------- */
    public function checkjoquantity(Request $request)
    {        
        $q = WorkOrder::where('ID',$request->jo_id)->pluck('PLAN_QTY')->first();
        $o = Pcb::where('jo_id',$request->jo_id)->where('type',1)->count();
        $t = $q - $o;
        if($t>0){
            return $this->scanserial($request);
            /* return [
                'type' => 'error',
                'message' => 'TEST'
            ]; */
        }
        else{
            return [
                'type' => 'error',
                'message' => 'Scan Failed. Plan Quantity is reached.'
            ];
        }
        return [
            'type' => 'error',
            'message' => 'API ERROR: checkjoquantity'
        ];
    }
    public function scanserial($request)
    {
        /* checking input */
        if($request->type == 1){
            $sn = Pcb::where('serial_number',$request->serial_number)
                ->where('div_process_id',$request->div_process_id)
                ->where('type',0);
            if($sn->first()){
                $sn = $sn->first();
                /* if($sn->jo_id == $request->jo_id){
                    return [
                        'type' => 'error',
                        'message' => 'same jo'
                    ];
                }
                else{
                    return [
                        'type' => 'success',
                        'message' => 'diff jo'
                    ];
                } */
                if($sn->first()->defect == 1){
                    return [
                        'type' => 'error',
                        'message' => 'Scan Failed. PCB has defect.'
                    ];
                }
                else{
                    if($sn->jo_id == $request->jo_id){
                        return $this->checkdup($request);
                    }
                    else{
                        return $this->checkdup($request,$sn->jo_id);
                    }
                    
                }       
            }
            else{
                return [
                    'type' => 'error',
                    'message' => 'Serial Number has no INPUT record.'
                ];
            }
            /* return [
                'type' => 'error',
                'message' => 'TEST'
            ]; */
        }
        else{
            /* Checking for bottom */
            if($request->division_id == 2 && $request->div_process_id == 2 ){
                $sn = Pcb::where('serial_number',$request->serial_number)->where('div_process_id',1)->where('type',1);
                if($sn->first()){
                    return $this->checkdup($request);
                }
                else{
                    return [
                        'type' => 'error',
                        'message' => 'Serial Number has no record on Bottom process.'
                    ];
                }
            }
            else{
                return $this->checkdup($request);
            }
            /* return $this->checkdup($request); */
            /* return [
                'type' => 'error',
                'message' => 'TEST'
            ]; */
        }
        return [
            'type' => 'error',
            'message' => 'API ERROR: scanserial'
        ];          
    }
    public function checkdup($request,$jo_id = '')
    {
        if($jo_id == ''){
            $sn = Pcb::where('serial_number',$request->serial_number)
                ->where('jo_id',$request->jo_id)
                ->where('div_process_id',$request->div_process_id)
                ->where('type',$request->type)
                ->first();
        }
        else{
            $sn = Pcb::where('serial_number',$request->serial_number)
                ->where('jo_id',$jo_id)
                ->where('div_process_id',$request->div_process_id)
                ->where('type',$request->type)
                ->first();
        }
        
        if(!$sn){
            return $this->insertsn($request,$jo_id);
        }
        else{
            return [
                'type' => 'error',
                'message' => 'Serial number already scanned.'
            ];
        }
        return [
            'type' => 'error',
            'message' => 'API ERROR: checkdup'
        ];
    }
    public function checkjoquantity2($request)
    {      
        $q = WorkOrder::where('ID',$request->jo_id)->pluck('PLAN_QTY')->first();
        $o = Pcb::where('jo_id',$request->jo_id)->where('type',1)->count();
        
        $t = $q - $o;
        if($t>0){
            return $this->insertsn($request);
        }
        else{
            return [
                'type' => 'error',
                'message' => 'Scan Failed. JO ' . $q->JOB_ORDER_NO . ' Plan Quantity is reached.'
            ];
        }
        return [
            'type' => 'error',
            'message' => 'API ERROR: checkjoquantity'
        ];
    }
    public function insertsn($request,$jo_id = '')
    {
        $a = new Pcb;
        $a->serial_number = $request->serial_number;
        if($jo_id == ''){
            $a->jo_id = $request->jo_id;
        }
        else{
            $a->jo_id = $jo_id;
        }
        
        $a->jo_number = $request->jo_number;
        $a->lot_id = 0;
        $a->division_id = $request->division_id;
        $a->line_id = $request->line_id;
        $a->div_process_id = $request->div_process_id;
        $a->type = $request->type;
        $a->employee_id = $request->employee_id;
        $a->shift = CustomFunctions::genshift();
        $a->defect = 0;
        $a->heat = 0;

        /* For Exporting */        
        if($request->division_id == 2 || $request->division_id == 17){
            $pname = Division::where('DIVISION_ID',$request->division_id)->pluck('DIVISION_NAME')->first();
            
            if($request->type == 0){
                $pname .= '.INPUT-';
            }
            else{
                $pname .= '.V/I-';
            }
            if($request->div_process_id == 1){
                $pname .= 'B';
            }
            elseif($request->div_process_id == 2){
                $pname .= 'T';
            }
        }
        $a->RESULT = 'OK';
        $a->PDLINE_NAME = LineName::where('id',$request->line_id)->pluck('name')->first();
        $a->PROCESS_NAME = $pname;

        if($a->save()){
            if($jo_id == ''){
                return [
                    'type' => 'success',
                    'message' => 'Scan Successful!'
                ];
            }
            else{
                return [
                    'type' => 'success',
                    'message' => 'Scan Successful! Scanned PCB is in different Work Order.'
                ];
            }
            
        }
        else{
            return [
                'type' => 'error',
                'message' => 'Scan Failed!'
            ];
        }
        return [
            'type' => 'error',
            'message' => 'API ERROR: insertsn'
        ];
    }
    public function totalscan(Request $request)
    {
        $q = WorkOrder::where('ID',$request->jo)->pluck('PLAN_QTY')->first();
        $in = Pcb::where('jo_id',$request->jo)->where('type',0)->count();
        $out = Pcb::where('jo_id',$request->jo)->where('type',1)->count();        
        $total = $q - $out;
        return [
            'in' => $in,
            'out' => $out,
            'total' => $total
        ];
    }
    public function loadempscantotaltable(Request $request)
    {
        $joid = $request->jo;
        $emptotals = Pcb::select('employee_id')
                    ->where('jo_id',$joid)
                    ->orderBy('id')
                    ->groupBy('employee_id')
                    ->get();
        
        return view('includes.scan.tsttab',compact('emptotals','joid'));
    }    
    /* DEFECTS */
    public function checksn(Request $request)
    {
        $a = Pcb::where('serial_number',$request->sn)->orderBy('id','DESC');
        if($a->first()){
            $p = $a->first();
            if($p->type == 0){
                if($p->defect){
                    return [
                        'type' => 'error',
                        'message' => 'Serial Number already has defect entry.<br>Please search the serial number for details.'
                    ];
                }
                return $a->first();
            }
            else{
                return [
                    'type' => 'error',
                    'message' => 'No input found. Please scan in first.'
                ];
            }            
        }
        else{
            return [
                'type' => 'error',
                'message' => 'Serial Number not found!'
            ];
        }
    }
    /* FEEDER LIST */
    
}
