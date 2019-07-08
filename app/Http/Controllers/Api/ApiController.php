<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MES\model\Employee;
use App\Http\Controllers\MES\model\LineName;
use App\Http\Controllers\MES\model\Machine;
use App\Http\Controllers\MES\model\Component;
use App\Models\DivProcess;
use App\Models\WorkOrder;
use App\Models\Pcb;
use App\Models\Lot;
use App\Models\Division;
use App\Models\MatComp;
use App\Models\MatSnComp;
use App\Custom\CustomFunctions;
use App\Jobs\CompSnInsert;

class ApiController extends Controller
{
    /*

    Message to the next developer.
    Please start at the event trigger by the element.
    Then check the function being call.
    Examine the function carefully.
    For ajax function, follow the url being requested.
    Follow the URL in the web.php
    Check the controller and the function used.
    GOODLUCK!
    
    */
    public function scanpinemp(Request $request)
    {
        if($request->input('check') == 1){
            if($name = Employee::select('id','fname','lname')->where('pin',$request->input('pin'))->first())
            {
                return $name;
            }
            else{
                return 0;
            }
        }
        elseif($request->input('check') == 2){
            if($name = Employee::select('id','fname','lname')->where('pin',$request->input('pin'))->where('repair',1)->first())
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
        $sap_code = Division::where('DIVISION_ID',$request->input('div'))->pluck('SAP_DIVISION_CODE')->first();
        $workorders = WorkOrder::where('JOB_ORDER_NO','LIKE',"{$sap_code}%")->where('DATE_',$request->input('dte'))->orderBy('MACHINE_CODE')->get();
        return view('includes.table.spTable',compact('workorders'));
    }
    public function loadpcbtable(Request $request)
    {
        if($request->input('sn')){
            $pcbs = Pcb::with('division','line','divprocess','employee','workorder')->where('serial_number',$request->input('sn'))->orderBy('id','DESC')->take(100)->get();
        }
        else{
            $pcbs = Pcb::with('division','line','divprocess','employee','workorder')->where('jo_id',$request->input('jo_id'))->where('div_process_id',$request->input('proc'))->where('type',$request->input('type'))->orderBy('id','DESC')->take(100)->get();
        }        
        return view('includes.table.pcbTable',compact('pcbs'));
    }

    /* ---------------------- PCB SCANNING -------------------------- */

    public function scantype(Request $request)
    {
        if(preg_match("/^([a-zA-Z0-9.]){12}$/", $request->serial_number)){
            if($request->type == 0){
                return $this->scanIn2($request);
            }
            else if($request->type == 1){
                return $this->scanOut2($request);
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
        else{
            return [
                'type' => 'error',
                'message' => 'Invalid Serial Number. Try Again.'
            ];
        }                       
    }

    /* --------------- INPUT SCANNING ------------------- */

    public function scanIn2($request)
    { 
        function checkdupIn($request)
        {
            $out = Pcb::select('div_process_id')->where('serial_number',$request->serial_number)
            ->where('div_process_id',$request->div_process_id)
            ->where('type',1)
            ->first();

            $in = Pcb::select('id')->where('serial_number',$request->serial_number)
                ->where('jo_id',$request->jo_id)
                ->where('div_process_id',$request->div_process_id)
                ->where('type',0)
                ->first();

            if(!$out){  
                if(!$in){
                    return checkjoquantity2($request);
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
        }
        function checkjoquantity2($request)
        {      
            $q = WorkOrder::where('ID',$request->jo_id)->pluck('PLAN_QTY')->first();
            $o = Pcb::select('id')->where('jo_id',$request->jo_id)->where('type',1)->count();
            
            $t = $q - $o;
            if($t>0){
                return insertsn($request);
            }
            else{
                return [
                    'type' => 'error',
                    'message' => 'Scan Failed. JO ' . $q->JOB_ORDER_NO . ' Plan Quantity is reached.'
                ];
            }
        }
        function insertsn( $request,$jo_id='')
        {
            if(preg_match("/^([a-zA-Z0-9.]){12}$/", $request->serial_number)){
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
                $mc_id = MatComp::select('id')->where('line_id',$a->line_id)->orderBy('id','DESC')->pluck('id')->first();
                $a->mat_comp_id = $mc_id;
        
                /* Insert mat_sn_comps table */                
                CompSnInsert::dispatch($request->serial_number,$mc_id);

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
                            'message' => 'Scan Successful! Scanned PCB is in different Job Order.'
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
            else{
                return [
                    'type' => 'error',
                    'message' => 'Invalid Serial Number. Try Again.'
                ];
            }            
        }
        if($request->division_id == 2 && $request->div_process_id == 2 ){
            $sn = Pcb::select('id')->where('serial_number',$request->serial_number)->where('div_process_id',1)->where('type',1);            
            if($sn->first()){
                return checkdupIn($request);
            }
            else{
                return [
                    'type' => 'error',
                    'message' => 'Serial Number has no record on Bottom process.'
                ];
            }
        }
        else{
            return checkdupIn($request);
        }
    }
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

    public function scanOut2($request)
    {
        /* CHECK FOR OUTPUT */
        $out = Pcb::select('div_process_id')->where('serial_number',$request->serial_number)
                ->where('div_process_id',$request->div_process_id)
                ->where('type',1)
                ->first();
        /* CHECK FOR INPUT */
        $sn = Pcb::select('defect')->where('serial_number',$request->serial_number)
                ->where('jo_id',$request->jo_id)
                ->where('div_process_id',$request->div_process_id)
                ->where('type',0);        
        
        function checkdupOut($request)
        {
            $out = Pcb::select('id')->where('serial_number',$request->serial_number)
                ->where('jo_id',$request->jo_id)
                ->where('div_process_id',$request->div_process_id)
                ->where('type',1)
                ->first();
    
            if(!$out){  
                return checkjoquantity2($request);
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
        function checkjoquantity2($request)
        {      
            $q = WorkOrder::where('ID',$request->jo_id)->pluck('PLAN_QTY')->first();
            $o = Pcb::select('id')->where('jo_id',$request->jo_id)->where('type',1)->count();
            
            $t = $q - $o;
            if($t>0){
                return insertsn($request);
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
        function insertsn($request,$jo_id = '')
        {
            if(preg_match("/^([a-zA-Z0-9.]){12}$/", $request->serial_number)){
                $a = new Pcb;
                $a->serial_number = $request->serial_number;
                if($jo_id == ''){
                    $a->jo_id = $request->jo_id;
                }
                else{
                    $a->jo_id = $jo_id;
                }
                
                $a->jo_number = $request->jo_number;
                /* $a->lot_id = $request->lot_id; */
                $a->lot_id = 0;
                $a->division_id = $request->division_id;
                $a->line_id = $request->line_id;
                $a->div_process_id = $request->div_process_id;
                $a->type = $request->type;
                $a->employee_id = $request->employee_id;
                $a->shift = CustomFunctions::genshift();
                $a->defect = 0;
                $a->heat = 0;
                $a->mat_comp_id = MatComp::select('id')->where('line_id',$a->line_id)->orderBy('id','DESC')->pluck('id')->first();

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
                            'message' => 'Scan Successful! Scanned PCB is in different Job Order.'
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
            else{
                return [
                    'type' => 'error',
                    'message' => 'Invalid Serial Number. Try Again.'
                ];
            }            
        }
        if(!$out){
            if($sn->first()){
                $sn = $sn->first();
                if($sn->defect == 1){
                    return [
                        'type' => 'error',
                        'message' => 'Scan Failed. PCB has defect.'
                    ];
                }
                else{                
                    return checkdupOut($request);               
                }       
            }
            else{
                $in = Pcb::select('jo_number')->where('serial_number',$request->serial_number)
                        ->where('div_process_id',$request->div_process_id)
                        ->where('type',0)->get();
                if($in->count() == 0){
                    return [
                        'type' => 'error',
                        'message' => 'Serial Number has no INPUT record.'
                    ];
                }
                else{
                    $jos = '';
                    foreach ($in as $i) {
                        $jos .= ' [' . $i->jo_number . ']';
                    } 
                    return [
                        'type' => 'error',
                        'message' => 'Serial Number has an INPUT in different Job Order/s.'.$jos                                               
                    ];
                }
                return [
                    'type' => 'error',
                    'message' => 'API ERROR: checking inputs'
                ];
            }
            return [
                'type' => 'error',
                'message' => 'API ERROR: scanOut'
            ];
        }
        else{
            return [
                'type' => 'error',
                'message' => 'Serial number already processed in ' . $out->divprocess->name . '.'
            ];
        }
    }
    public function scanOut($request)
    {
        /* CHECK FOR OUTPUT */
        $out = Pcb::where('serial_number',$request->serial_number)
                ->where('div_process_id',$request->div_process_id)
                ->where('type',1)
                ->first();
        /* CHECK FOR INPUT */
        $sn = Pcb::where('serial_number',$request->serial_number)
                ->where('jo_id',$request->jo_id)
                ->where('div_process_id',$request->div_process_id)
                ->where('type',0);        

        if(!$out){
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
                $in = Pcb::where('serial_number',$request->serial_number)
                        ->where('div_process_id',$request->div_process_id)
                        ->where('type',0)->get();
                if($in->count() == 0){
                    return [
                        'type' => 'error',
                        'message' => 'Serial Number has no INPUT record.'
                    ];
                }
                else{
                    $jos = '';
                    foreach ($in as $i) {
                        $jos .= ' [' . $i->jo_number . ']';
                    } 
                    return [
                        'type' => 'error',
                        'message' => 'Serial Number has an INPUT in different Work Order/s.'.$jos                                               
                    ];
                }
                return [
                    'type' => 'error',
                    'message' => 'API ERROR: checking inputs'
                ];
            }
            return [
                'type' => 'error',
                'message' => 'API ERROR: scanOut'
            ];
        }
        else{
            return [
                'type' => 'error',
                'message' => 'Serial number already processed in ' . $out->divprocess->name . '.'
            ];
        }
        
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
    public function getlotnumber(Request $request){
        return Lot::where('jo_id',$request->input('jo'))->where('status',0)->first();        
    }
    public function createlotnumber(Request $request){
        $a = new Lot;
        $a->number = CustomFunctions::genlotnumber($request->input('div'),$request->input('line'));
        $a->jo_id = $request->jo;
        $a->created_by = $request->eid;
        $a->save();
        return $a;
    }
    public function closelotnumber(Request $request){
        $e = Lot::where('id',$request->input('ln'))->first();
        $e->status = 1;
        $e->closed_by = $request->eid;
        $e->closed_at = Date('Y-m-d H:i:s');
        if($e->save()){
            return 1;
        }
        else{
            return 0;
        }
    }
    public function getlotnumbertotal(Request $request){
        return Pcb::where('lot_id',$request->input('ln'))->count();        
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


    /* mat_comp - mat_sn_comp */

    public static function insertmatcomp(Request $request,$mat_load_id)
    {
        $machine = $request->machine_id;
        $m_code =substr($machine,0,-1);
        $mach = Machine::where('barcode',$m_code)->first();
        $line_id = $mach->line->linename->id;
        $component= Component::where('product_number',$request->new_PN)->first();
        $m = MatComp::where('model_id',$request->model_id)->where('line_id',$line_id)->orderBy('id','DESC')->first();
        
        if($m){
            $mt = $m->materials;
            $tu = '';
            foreach ($mt as $key => $value) {
                if($value['machine'] == $request->machine_id && $value['position'] == $request->position && $value['feeder'] == $request->feeder_slot){
                    $tu = $key;
                    break;
                }
            }                
            unset($mt[$tu]);
            $im = new MatComp;
            $im->model_id = $request->model_id;
            $im->line_id = $line_id;
            $im->mat_load_id = $mat_load_id;
            $im->materials = $mt;
            $mt2 = $im->materials;
            $mt2[$component->id] = [
                                'machine' => $request->machine_id,
                                'position' => $request->position,
                                'feeder' => $request->feeder_slot,
                                'RID' => $request->comp_rid,
                                'QTY' => $request->comp_qty
                                ];
            $im->materials = $mt2;
            try {
                $im->save();
            } catch (\Throwable $th) {
                Log::error($th);
            }
        }
        else{
            $im = new MatComp;
            $im->model_id = $request->model_id;
            $im->line_id = $line_id;
            $mt = $im->materials;
            $mt[$component->id] = [
                                'machine' => $request->machine_id,
                                'position' => $request->position,
                                'feeder' => $request->feeder_slot,
                                'RID' => $request->comp_rid,
                                'QTY' => $request->comp_qty
                                ];
            $im->materials = $mt;
            try {
                $im->save();
            } catch (\Throwable $th) {
                Log::error($th);
            }            
        }

    }
}
