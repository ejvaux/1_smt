<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MES\model\Employee;
use App\Http\Controllers\MES\model\LineName;
use App\Http\Controllers\MES\model\Machine;
use App\Http\Controllers\MES\model\Component;
use App\Http\Controllers\MES\model\Modname;
use App\Models\DivProcess;
use App\Models\WorkOrder;
use App\Models\Pcb;
use App\Models\PcbArchive;
use App\Models\Lot;
use App\Models\Division;
use App\Models\MatComp;
use App\Models\MatComp1;
use App\Models\MatSnComp;
use App\Models\WoSn;
use App\Models\LotConfig;
use App\Custom\CustomFunctions;
use App\Jobs\CompSnInsert;
use App\Jobs\RemoteInsert;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\MaterialCount;
use App\tableSMT;
use App\feeders;

class ApiController extends Controller
{
    /*

    Message to the next developer.

    Please start at the trigger event of the element.
    Then check the function being called.
    Examine the function carefully.
    For ajax functions, follow the url being requested.
    Follow the URL in the routes.
    Check the controller and the method used.
    
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
        $workorders = WorkOrder::where('JOB_ORDER_NO','LIKE',"{$sap_code}%")->where('DATE_',$request->input('dte'))->where('MACHINE_CODE',$request->input('line'))->orderBy('MACHINE_CODE')->get();
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
        // ----------------------------
        // Checking process status
        // ----------------------------

        try {
            $archive = PcbArchive::select('div_process_id','type','exported','defect')->where('serial_number',$request->serial_number);
            $pcb = Pcb::select('div_process_id','type','exported','defect')->where('serial_number',$request->serial_number)
                            ->union($archive)
                            ->get();
        } catch (\Throwable $th) {
            Log::error($th);
            return [
                'type' => 'error',
                'message' => 'ERROR: Retrieving PCB data.(1)'
            ];
        }

        if($request->division_id == 2)
        {
            if ($request->div_process_id == 1)
            {
                $to = $pcb->filter(function ($value){
                    return $value->div_process_id == 2 && $value->type == 1;
                })->all();
    
                $toe = $pcb->filter(function ($value){
                    return $value->div_process_id == 2 && $value->type == 1 && $value->exported == 1;
                })->all();
    
                if($toe){
                    return [
                        'type' => 'error2',
                        'title' => 'SMT process already finished and exported.',
                        'message' => 'Please check for duplicate Serial Numbers. In case of duplicate, please contact your immediate superior or MIS SUPPORT.'
                    ];
                }
                else if($to){
                    return [
                        'type' => 'error2',
                        'title' => 'SMT process already finished',
                        'message' => 'Please check for duplicate Serial Numbers. In case of duplicate, please contact your immediate superior or MIS SUPPORT.'
                    ];
                }           
            }


            // --------------------------
            // Setting div process for SMT
            // --------------------------

            $icode = WorkOrder::where('ID',$request->jo_id)->pluck('ITEM_CODE')->first();
            if($icode[-1] == 'B' || $icode[-1] == 'b'){
                $dproc = 1;
            }
            else if($icode[-1] == 'T'){
                $dproc = 2;
            }
            else {
                return [
                    'type' => 'error',
                    'message' => 'ITEM CODE is not recognized. Cannot input scan process. Please contact the system support.'
                ];
            }
            $request->div_process_id = $dproc;

            // -----------------
            // Matching SN to WO
            // -----------------

            if($request->work_order){
                $wo = $request->work_order;
            }
            else{
                $wo = WorkOrder::where('id',$request->jo_id)->pluck('SALES_ORDER')->first();
            }
            $sn = WoSn::select('WORK_ORDER')->where('SERIAL_NUMBER',$request->serial_number)->first();
            if($sn){
                if($sn->WORK_ORDER == $wo){
                    if($request->type == 0){
                        return $this->scanIn($request,$pcb);
                    }
                    else if($request->type == 1){
                        return $this->scanOut($request,$pcb);
                    }
                    else{
                        return [
                            'type' => 'error',
                            'message' => 'Scan Failed. Scan type not allowed.'
                        ];
                    }
                    /* return $this->checkreelqty($request); */
                }
                else{
                    return [
                        'type' => 'error',
                        'message' => 'Serial Number is in different Work Order.<br>Please use JOB ORDER with WORK ORDER below:<br><b><h4 class="text-center">'.$sn->WORK_ORDER.'</h4></b>'
                    ];
                }
            }
            else{
                return [
                    'type' => 'error',
                    'message' => 'Serial Number does not exist in the database.'
                ];
            }
        }
        else
        {
            if(preg_match("/^([a-zA-Z0-9.]){12}$/", $request->serial_number)){
                if($request->type == 0){
                    return $this->scanIn($request,$pcb);
                }
                else if($request->type == 1){
                    return $this->scanOut($request,$pcb);
                }
                else{
                    return [
                        'type' => 'error',
                        'message' => 'Scan Failed. Scan type not allowed.'
                    ];
                }
                /* return $this->checkreelqty($request); */                
            }
            else{
                return [
                    'type' => 'error',
                    'message' => 'Invalid Serial Number. Try Again.'
                ];
            }
        }                 
    }

    /* ----------------- VALIDATION --------------------- */    

    public function checkreelqty($request){
        if($request->line_id == 17 || $request->line_id == 18){
            $model = Modname::where('lines','LIKE','%"'.$request->line_id.'"%')->first();
            if($model){
                $reps = MaterialCount::where('model_id',$model->id)->where('line_id',$request->line_id)->whereNotNull('mat_load_id')->where('remaining_qty','<',0)->get();
                if($reps->count() > 0){
                    foreach ($reps as $rep) {
                        if($rep->remaining_qty <= $rep->reel_qty * -3){
                            return [
                                'type' => 'error',
                                'message' => '<h3>Negative reel quantity found. Please Check Reel for Replenish.</h3>'
                            ];
                        }
                    }                    
                }
            }
        }        
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
    }

    /* --------------- INPUT SCANNING ------------------- */
    
    public function scanIn($request, $pcb)
    {
        // -------------------
        // Retrieving PCB data
        // -------------------

        /* try {
            $archive = PcbArchive::select('div_process_id','type','defect')->where('serial_number',$request->serial_number);
            $pcb = Pcb::select('div_process_id','type','defect')->where('serial_number',$request->serial_number)
                            ->union($archive)
                            ->get();
        } catch (\Throwable $th) {
            Log::error($th);
            return [
                'type' => 'error',
                'message' => 'ERROR: Retrieving PCB data.'
            ];
        } */

        // ------------------
        // Checking duplicate
        // ------------------

        function checkdup($request,$pcb)
        {
            $out = $pcb->filter(function ($value) use ($request) {
                return $value->div_process_id == $request->div_process_id && $value->type == 1;
            })->all();

            $in = $pcb->filter(function ($value) use ($request) {
                return $value->div_process_id == $request->div_process_id && $value->type == 0;
            })->all();

            // ---------------------
            // Check div process OUT
            // ---------------------

            if(!$out)
            {
                // ---------------------
                // Check div process IN
                // ---------------------

                if(!$in){
                    /* return defectCheck($request,$pcb); */
                    return checkjoquantity($request,$pcb);
                }
                else{
                    return [
                        'type' => 'error',
                        'message' => 'Serial number already scanned in ' . DivProcess::where('id',$request->div_process_id)->pluck('name')->first() . ' IN.'
                    ];
                }
            }
            else{
                return [
                    'type' => 'error',
                    'message' => 'Serial number already processed in ' . DivProcess::where('id',$request->div_process_id)->pluck('name')->first() . '.'
                ];
            }
        }

        // --------------------
        // Checking for defects
        // --------------------

        function defectCheck($request,$pcb)
        {
            $def = $pcb->filter(function ($value){
                        return $value->defect == 1;
                    })->all();
            
            if(!$def){
                /* return checkjoquantity($request,$pcb); */
                return checkdup($request,$pcb);
            }
            else{
                return [
                    'type' => 'error',
                    'message' => 'Scan Failed. PCB has defect.'
                ];
            }               
        }

        // ---------------------------
        // Check JO remaining quantity
        // ---------------------------

        function checkjoquantity($request)
        {
            $w = WorkOrder::select('PLAN_QTY','JOB_ORDER_NO')->where('ID',$request->jo_id)->first();
            $q = $w->PLAN_QTY;
            $q1 = $w->JOB_ORDER_NO;
            
            $archive = PcbArchive::select('id')
                            ->where('jo_id',$request->jo_id)
                            ->where('type',1);
            $o = Pcb::select('id')
                    ->where('jo_id',$request->jo_id)
                    ->where('type',1)
                    ->union($archive)
                    ->count();

            $t = $q - $o;
            if($t>0){
                return insertsn($request);
            }
            else{
                return [
                    'type' => 'error',
                    'message' => 'Scan Failed. JO # ' . $q1 . ' Plan Quantity is reached.'
                ];
            }
        }

        // ---------------
        // Insert pcb data
        // ---------------

        function insertsn($request)
        {
            try {   
                DB::transaction(function () use($request) {
                    $a = new Pcb;
                    $a->serial_number = strtoupper($request->serial_number);
                    $a->jo_id = $request->jo_id;
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
                    $a->work_order = $request->work_order;

                // Machine Component
                    /* $mcid = MatComp::where('line_id',$a->line_id)->orderBy('id','DESC')->first();

                    if($mcid){
                        $a->mat_comp_id = $mcid->id;                            
                    }
                    else{
                        $a->mat_comp_id = null;
                    } */

                // For Exporting        
                    if($request->division_id == 2){
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
                    else if( $request->division_id == 17 || $request->division_id == 18){
                        $pname = 'DIP';
                        if($request->type == 0){
                            $pname .= '.INPUT';
                        }
                        else{
                            $pname .= '.V/I';
                        }
                    }
                    else{
                        $pname = '';
                    }
                    $a->RESULT = 'OK';
                    $a->PDLINE_NAME = LineName::where('id',$request->line_id)->pluck('name')->first();
                    $a->PROCESS_NAME = $pname;
                    $a->save();

                // Insert mat_sn_comps table
                    /* if($mcid){                    
                        try {
                            CompSnInsert::dispatch($request->serial_number,$mcid->id);
                        } catch (\Throwable $th) {
                            Log::error($th);
                        }
                    } */                        
                    
                }, 3);
                return [
                    'type' => 'success',
                    'message' => 'Scan Successful!'
                ];  
            } catch (\Throwable $th) {
                if($th->getCode() == 23000){
                    return [
                        'type' => 'error',
                        'message' => 'Serial Number Already Scanned.'
                    ];
                }
                else{
                    Log::error("[PCB SCAN IN] ".$th);
                    return [
                        'type' => 'error',
                        'message' => 'Scan Failed. Please try again.'
                    ];
                }                    
            }          
        }
        
        // -------------------
        // CHECKING BOTTOM OUT
        // -------------------

        if ($request->division_id == 2 && $request->div_process_id == 2 )
        {
            $msg = '';
            $bo = $pcb->filter(function ($value){
                return $value->div_process_id == 1 && $value->type == 1;
            })->all();

            if($bo){
                return defectCheck($request,$pcb);
            }
            else{
                $msg = '<b>BOTTOM OUT</b><br>';
                $bi = $pcb->filter(function ($value){
                    return $value->div_process_id == 1 && $value->type == 0;
                })->all();

                if(!$bi){
                    $msg = $msg.'<b>BOTTOM IN</b><br>';
                }
                return [
                    'type' => 'error',
                    'message' => 'Serial Number has no scan in:<br><div style="text-align:center;">'.$msg.'</div>'
                ];            
            }
        }

        // ----------------
        // CHECKING TOP OUT
        // ----------------

        elseif ($request->division_id == 18 && $request->div_process_id == 5 )
        {
            $msg = '';
            $to = $pcb->filter(function ($value){
                return $value->div_process_id == 2 && $value->type == 1;
            })->all();

            if($to){
                return defectCheck($request,$pcb);
            }
            else{
                $msg = '<b>TOP OUT</b><br>';
                $ti = $pcb->filter(function ($value){
                    return $value->div_process_id == 2 && $value->type == 0;
                })->all();
                $bo = $pcb->filter(function ($value){
                    return $value->div_process_id == 1 && $value->type == 1;
                })->all();
                $bi = $pcb->filter(function ($value){
                    return $value->div_process_id == 1 && $value->type == 0;
                })->all();
                
                if(!$ti){
                    $msg = $msg.'<b>TOP IN</b><br>';                    
                }
                if(!$bo){
                    $msg = $msg.'<b>BOTTOM OUT</b><br>';
                }
                if(!$bi){
                    $msg = $msg.'<b>BOTTOM IN</b><br>';
                }
                return [
                    'type' => 'error',
                    'message' => 'Serial Number has no scan in:<br><div style="text-align:center;">'.$msg.'</div>'
                ];
            }
        }
        else 
        {
            return defectCheck($request,$pcb);
        }
    } 

    /* ------------- OUTPUT SCANNING ------------------- */

    public function scanOut($request, $pcb)
    {
        // -------------------
        // Retrieving PCB data
        // -------------------

        /* try {
            $archive = PcbArchive::select('div_process_id','type','defect','mat_comp_id')->where('serial_number',$request->serial_number);
            $pcb = Pcb::select('div_process_id','type','defect','mat_comp_id')->where('serial_number',$request->serial_number)
                            ->union($archive)
                            ->get();
        } catch (\Throwable $th) {
            Log::error($th);
            return [
                'type' => 'error',
                'message' => 'ERROR: Retrieving PCB data.'
            ];
        } */

        // ------------------
        // Checking duplicate
        // ------------------

        function checkdup($request,$pcb)
        {
            $out = $pcb->filter(function ($value) use ($request) {
                return $value->div_process_id == $request->div_process_id && $value->type == 1;
            })->all();

            // ---------------------
            // Check div process OUT
            // ---------------------

            if(!$out)
            {
                return checkjoquantity($request,$pcb);
            }
            else{
                return [
                    'type' => 'error',
                    'message' => 'Serial number already processed in ' . DivProcess::where('id',$request->div_process_id)->pluck('name')->first() . '.'
                ];
            }
        }

        // --------------------
        // Checking for defects
        // --------------------

        function defectCheck($request,$pcb)
        {
            $def = $pcb->filter(function ($value){
                        return $value->defect == 1;
                    })->all();
            
            if(!$def){
                /* return checkjoquantity($request,$pcb); */
                return checkdup($request,$pcb);
            }
            else{
                return [
                    'type' => 'error',
                    'message' => 'Scan Failed. PCB has defect.'
                ];
            }               
        }

        // ---------------------------
        // Check JO remaining quantity
        // ---------------------------

        function checkjoquantity($request,$pcb)
        {
            $w = WorkOrder::select('PLAN_QTY','JOB_ORDER_NO')->where('ID',$request->jo_id)->first();
            $q = $w->PLAN_QTY;
            $q1 = $w->JOB_ORDER_NO;
            
            $archive = PcbArchive::select('id')
                            ->where('jo_id',$request->jo_id)
                            ->where('type',1);
            $o = Pcb::select('id')
                    ->where('jo_id',$request->jo_id)
                    ->where('type',1)
                    ->union($archive)
                    ->count();

            $t = $q - $o;
            if($t>0){
                return insertsn($request,$pcb);
            }
            else{
                return [
                    'type' => 'error',
                    'message' => 'Scan Failed. JO # ' . $q1 . ' Plan Quantity is reached.'
                ];
            }
        }
        
        // ---------------
        // Insert pcb data
        // ---------------
        
        function insertsn($request,$pcb)
        {
            try {
                DB::transaction(function () use($request,$pcb) {
                    $a = new Pcb;
                    $a->serial_number = strtoupper($request->serial_number);
                    $a->jo_id = $request->jo_id;      
                    if($request->lot_id){
                        $a->lot_id = $request->lot_id;
                    }
                    else{
                        $a->lot_id = 0;
                    }
                    $a->jo_number = $request->jo_number;
                    $a->division_id = $request->division_id;
                    $a->line_id = $request->line_id;
                    $a->div_process_id = $request->div_process_id;
                    $a->type = $request->type;
                    $a->employee_id = $request->employee_id;
                    $a->shift = CustomFunctions::genshift();
                    $a->defect = 0;
                    $a->heat = 0;

                    /* work order */
                    $a->work_order = $request->work_order;

                // Machine Component
                    $mcomp1 = $pcb->filter(function ($value) use ($request) {
                        return $value->div_process_id == $request->div_process_id && $value->type == 0;
                    })->all();
                    $mcomp2 = array_values($mcomp1);
                    $mcomp = $mcomp2[0]['mat_comp_id'];
                    if ($mcomp == null) {
                        $mcid = MatComp::where('line_id',$a->line_id)->orderBy('id','DESC')->first();

                        if($mcid){
                            $a->mat_comp_id = $mcid->id;                            
                        }
                        else{
                            $a->mat_comp_id = null;
                        }
                    }                    

                    /* For Exporting */        
                    if($request->division_id == 2){
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
                    else if( $request->division_id == 17 || $request->division_id == 18){
                        $pname = 'DIP';
                        if($request->type == 0){
                            $pname .= '.INPUT';
                        }
                        else{
                            $pname .= '.V/I';
                        }
                    }
                    else{
                        $pname = '';
                    }
                    $a->RESULT = 'OK';
                    $a->PDLINE_NAME = LineName::where('id',$request->line_id)->pluck('name')->first();
                    $a->PROCESS_NAME = $pname;
                    $a->save();

                // Insert mat_sn_comps table
                    if ($mcomp == null){
                        if($mcid){                    
                            try {
                                CompSnInsert::dispatch($request->serial_number,$mcid->id);
                            } catch (\Throwable $th) {
                                Log::error($th);
                            }
                        }
                    }                    

                }, 3);
                return [
                    'type' => 'success',
                    'message' => 'Scan Successful!'
                ];
            } catch (\Throwable $th) {
                if($th->getCode() == 23000){
                    return [
                        'type' => 'error',
                        'message' => 'Serial Number Already Scanned.'
                    ];
                }
                else{
                    Log::error("[PCB SCAN OUT] ".$th);
                    return [
                        'type' => 'error',
                        'message' => 'Scan Failed. Please try again.'
                    ];
                }
            }           
        }
        
        // ----------------
        // CHECKING BOTTOM IN
        // ----------------

        if ($request->division_id == 2 && $request->div_process_id == 1 ) {
            $msg = '';
            $bi = $pcb->filter(function ($value){
                return $value->div_process_id == 1 && $value->type == 0;
            })->all();
            if ($bi) {
                return defectCheck($request,$pcb);
            }
            else{
                $msg = '<b>BOTTOM IN</b><br>';
                return [
                    'type' => 'error',
                    'message' => 'Serial Number has no scan in:<br><div style="text-align:center;">'.$msg.'</div>'
                ];
            }
        }

        // ----------------
        // CHECKING TOP IN
        // ----------------

        elseif ($request->division_id == 2 && $request->div_process_id == 2 ) {
            $msg = '';
            $ti = $pcb->filter(function ($value){
                return $value->div_process_id == 2 && $value->type == 0;
            })->all();
            if ($ti) {
                return defectCheck($request,$pcb);
            }
            else{
                $msg = '<b>TOP IN</b><br>';
                $bo = $pcb->filter(function ($value){
                    return $value->div_process_id == 1 && $value->type == 1;
                })->all();
                $bi = $pcb->filter(function ($value){
                    return $value->div_process_id == 1 && $value->type == 0;
                })->all();
                if (!$bo) {
                    $msg = $msg.'<b>BOTTOM OUT</b><br>';
                }
                if (!$bi) {
                    $msg = $msg.'<b>BOTTOM IN</b><br>';
                }
                return [
                    'type' => 'error',
                    'message' => 'Serial Number has no scan in:<br><div style="text-align:center;">'.$msg.'</div>'
                ];
            }
        }

        // ----------------
        // CHECKING DIP IN
        // ----------------

        elseif ($request->division_id == 18 && $request->div_process_id == 5) {
            $msg = '';
            $di = $pcb->filter(function ($value){
                return $value->div_process_id == 5 && $value->type == 0;
            })->all();
            if ($di) {
                return defectCheck($request,$pcb);
            }
            else{
                $msg = '<b>DIP IN</b><br>';
                $to = $pcb->filter(function ($value){
                    return $value->div_process_id == 2 && $value->type == 1;
                })->all();
                $ti = $pcb->filter(function ($value){
                    return $value->div_process_id == 2 && $value->type == 0;
                })->all();
                $bo = $pcb->filter(function ($value){
                    return $value->div_process_id == 1 && $value->type == 1;
                })->all();
                $bi = $pcb->filter(function ($value){
                    return $value->div_process_id == 1 && $value->type == 0;
                })->all();
                if (!$to) {
                    $msg = $msg.'<b>TOP OUT</b><br>';
                }
                if (!$ti) {
                    $msg = $msg.'<b>TOP IN</b><br>';
                }
                if (!$bo) {
                    $msg = $msg.'<b>BOTTOM OUT</b><br>';
                }
                if (!$bi) {
                    $msg = $msg.'<b>BOTTOM IN</b><br>';
                }
                return [
                    'type' => 'error',
                    'message' => 'Serial Number has no scan in:<br><div style="text-align:center;">'.$msg.'</div>'
                ];
            }
        }

        /* return defectCheck($request,$pcb); */
    }

    /* --------------------------------------------------------------------- */
    public function totalscan(Request $request)
    {
        $q = WorkOrder::where('ID',$request->jo)->pluck('PLAN_QTY')->first();
        $pcb = Pcb::select('id','type')->where('jo_id',$request->jo)->get();
        $in = $pcb->filter(function ($val) {
                    return $val->type == 0;
                })->count();
        $out = $pcb->filter(function ($val) {
                    return $val->type == 1;
                })->count();
        /* $in = Pcb::where('jo_id',$request->jo)->where('type',0)->count();
        $out = Pcb::where('jo_id',$request->jo)->where('type',1)->count(); */        
        $total = $q - $out;
        $total_in = $q - $in;
        return [
            'in' => $in,
            'out' => $out,
            'total' => $total,
            'total_in' => $total_in
        ];
    }
    public function loadempscantotaltable(Request $request)
    {
        $joid = $request->jo;
        $emptotals = [];
        /* $emptotals = Pcb::select('employee_id')
                    ->where('jo_id',$joid)
                    ->orderBy('id')
                    ->groupBy('employee_id')
                    ->get(); */
        $emps = Pcb::with('employee')
                    ->select('employee_id')
                    ->where('jo_id',$joid)
                    ->groupBy('employee_id')
                    ->get();
        
        $pcb = Pcb::select('employee_id','type')
                ->where('jo_id',$joid)
                ->get();

        foreach ($emps as $emp) {
            $emptotals[] = [
                'name' => $emp->employee->fname . " " . $emp->employee->lname,
                'in' => $pcb->filter(function ($val) use ($emp) {
                            return $val->employee_id == $emp->employee_id && $val->type == 0;
                        })->count(),
                'out' => $pcb->filter(function ($val) use ($emp) {
                            return $val->employee_id == $emp->employee_id && $val->type == 1;
                        })->count()
            ];
        }
        /* return $emptotals; */
        return view('includes.scan.tsttab',compact('emptotals','joid'));
    }
    public function getlotnumber(Request $request)
    {
        return Lot::where('jo_id',$request->input('jo'))->where('status',0)->first();        
    }
    public function createlotnumber(Request $request)
    {
        $t = Lot::where('jo_id',$request->input('jo'))->where('status',0)->first();
        if($t){
            return 0;
        }
        else{
            $a = new Lot;
            $a->number = CustomFunctions::genlotnumber($request->input('div'),$request->input('line'));
            $a->jo_id = $request->jo;
            $a->created_by = $request->eid;
            $a->save();
            return $a;
        }        
    }
    public function closelotnumber(Request $request)
    {
        $qty = Pcb::where('lot_id',$request->input('ln'))->count();
        
        if($qty > 0){
            $e = Lot::where('id',$request->input('ln'))->first();
            $e->status = 1;
            $e->closed_by = $request->eid;
            $e->closed_at = Date('Y-m-d H:i:s');
            $e->qty = Pcb::where('lot_id',$request->input('ln'))->count();
            if($e->save()){
                return [
                    'type' => 'success',
                    'message' => 'Lot Number Closed Successfully!'
                ];
            }
            else{
                return [
                    'type' => 'error',
                    'message' => 'Lot closing failed. Try Again.'
                ];
            }
        }
        else{
            return [
                'type' => 'error',
                'message' => 'Cannot close empty lot.'
            ];
        }
        
        return [
            'type' => 'error',
            'message' => 'API Error: Close Lot'
        ];
    }
    public function getlotnumbertotal(Request $request)
    {
        return Pcb::where('lot_id',$request->input('ln'))->count();        
    }
    public function getlotconfig(Request $request)
    {
        $lc = LotConfig::where('part_code',$request->pc)->first();
        if($lc){
            return $lc->div_process_id;
        }
        else{
            return 0;
        }
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
            elseif($p->type == 1){
                $msg = [
                    'type' => 'error',
                    'message' => 'Serial Number has no input. No input will be updated.'
                ];
                /* $Pcbs1->merge($Pcbs2) */
                /* return $a->first(); */
                $data = $a->first();
                /* $data['type'] = 'error'; */
                /* $data['message'] = 'Serial Number has no input. No input will be marked as defect.'; */
                return $data;
            }
            else{
                return [
                    'type' => 'error',
                    'message' => 'No input and output found. Please scan in first.'
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

    public static function insertmatcomp(Request $request,$mat_load)
    {
        $machine = $request->machine_id;
        $m_code =substr($machine,0,-1);
        $mach = Machine::where('barcode',$m_code)->first();
        $line_id = $mach->line->linename->id;
        $component= Component::where('product_number',$request->new_PN)->first();
        $m = MatComp::where('model_id',$mat_load->model_id)->where('line_id',$line_id)->latest('id')->first();
        
        if($m){
            $mt = $m->materials;
            $tu = '';
            foreach ($mt as $key => $value) {
                if(
                    strtoupper($value['machine']) == strtoupper($request->machine_id) && 
                    $value['position'] == $request->position && 
                    $value['feeder'] == $request->feeder_slot
                    )
                {
                    $tu = $key;
                    unset($mt[$tu]);
                }
            }

            $im = new MatComp;
            $im->model_id = $mat_load->model_id;
            $im->line_id = $line_id;
            $im->mat_load_id = $mat_load->id;
            $im->materials = $mt;
            $mt2 = $im->materials;
            $mt2[] = [
                                'component_id' => $component->id,
                                'machine' => strtoupper($request->machine_id),
                                'position' => $request->position,
                                'feeder' => $request->feeder_slot,
                                'RID' => $request->comp_rid,
                                'QTY' => $request->comp_qty,
                                'matload_id' => $mat_load->id
                                ];
            $im->materials = $mt2;
            $im->save();
        }
        else{
            $im = new MatComp;
            $im->model_id = $mat_load->model_id;
            $im->line_id = $line_id;
            $im->mat_load_id = $mat_load->id;
            $mt = $im->materials;
            $mt[] = [
                                'component_id' => $component->id,
                                'machine' => strtoupper($request->machine_id),
                                'position' => $request->position,
                                'feeder' => $request->feeder_slot,
                                'RID' => $request->comp_rid,
                                'QTY' => $request->comp_qty,
                                'matload_id' => $mat_load->id
                                ];
            $im->materials = $mt;
            $im->save();         
        }
    }

    public static function insertmatcomp1($req)
    {
        $matcomp_id = 0;
        $machine = $req['machine_id'];
        $m_code =substr($machine,0,-1);
        $table=substr($machine,-1);
        $mach = Machine::where('barcode',$m_code)->first();
        $line_id = $mach->line->linename->id;
        $component= Component::where('product_number',$req['new_PN'])->first();
        
        $model = ModName::where('lines','LIKE','%"'.$line_id.'"%')->first();        
        $table_id= tableSMT::where('name',$table)->pluck('id')->first();

        $feeder=feeders::where('model_id',$model->id)
                    ->where('line_id',$line_id)
                    ->where('machine_type_id',$mach->machine_type_id)
                    ->where('table_id',$table_id)
                    ->where('mounter_id',$req['feeder_slot'])
                    ->where('pos_id',$req['position'])
                    ->where('component_id',$component->id)
                    ->first();
                    
        if(!$feeder){
            return [
                'id' => 0,
                'message' => 'Error retrieving feeder. Try again. If error persist contact MIS.'
            ];
        }
        
        $m = MatComp::where('model_id',$req['model_id'])->where('line_id',$line_id)->latest('id')->first();
        
        if($m){
            $mt = $m->materials;
            $tu = '';
            $p_comp = '';
            $p_rid = '';
            $p_qty = '';
            foreach ($mt as $key => $value) {
                if(
                    strtoupper($value['machine']) == strtoupper($req['machine_id']) && 
                    $value['position'] == $req['position'] && 
                    $value['feeder'] == $req['feeder_slot']
                    )
                {
                    $p_comp = $value['component_id'];
                    $p_rid = $value['RID'];
                    $p_qty = $value['QTY'];
                    $tu = $key;
                    unset($mt[$tu]);
                }
            }

            // Check if prev reel is finished

            /* $total = 0;
            $serials = MatSnComp::where('RID',$p_rid)->get();
            $sns = [];
            if($serials){
                foreach ($serials as $serial) {            
                    foreach ($serial->sn as $s) {
                        $sns[] = $s;
                    }
                }
            }
            $total = count(array_unique($sns));
            $usagee = 0;
            if($feeder->usage <= 0){
                return [
                    'id' => 0,
                    'message' => 'Usage is not set on the feeder.'
                ];
            }
            else{
                $usagee = $feeder->usage;
            }
            $sys_qty = $total * $usagee;

            if($sys_qty < $p_qty * 0.05){
                return [
                    'id' => 0,
                    'message' => 'Previous Reel not yet ready for replenish.'
                ];
            } */

            $im = new MatComp;
            $im->model_id = $req['model_id'];
            $im->line_id = $line_id;
            /* $im->mat_load_id = $req['id']; */
            $im->materials = $mt;
            $mt2 = $im->materials;
            $mt2[] = [
                    'feeder_id' => $feeder->id,                    
                    'machine' => strtoupper($req['machine_id']),
                    'position' => $req['position'],
                    'feeder' => $req['feeder_slot'],
                    'matload_id' => 'processing',

                    'prev_comp_id' => $p_comp,
                    'prev_RID' => $p_rid,
                    'prev_QTY' => $p_qty,

                    'component_id' => $component->id,
                    'RID' => $req['comp_rid'],
                    'QTY' => $req['comp_qty']
                    ];
            $zz = array_values($mt2);
            $im->materials = $zz;            
            $im->save();
            $matcomp_id = $im->id;
        }
        else{
            $im = new MatComp;
            $im->model_id = $req['model_id'];
            $im->line_id = $line_id;
            /* $im->mat_load_id = $req['id']; */
            $mt = $im->materials;
            $mt[] = [
                    'feeder_id' => $feeder->id,
                    'machine' => strtoupper($req['machine_id']),
                    'position' => $req['position'],
                    'feeder' => $req['feeder_slot'],
                    'matload_id' => 'processing',

                    'prev_comp_id' => '',
                    'prev_RID' => '',
                    'prev_QTY' => '',

                    'component_id' => $component->id,
                    'RID' => $req['comp_rid'],
                    'QTY' => $req['comp_qty']
                    ];
            $zzz = array_values($mt);        
            $im->materials = $zzz;
            $im->save();
            $matcomp_id = $im->id;
        }
        /* return $matcomp_id; */
        return [
            'id' => $matcomp_id,
            'message' => ''
        ];
    }
}
