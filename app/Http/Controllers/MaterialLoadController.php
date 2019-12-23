<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
use App\modelSMT;
use App\RunningOnMachine;
use Response;
use App\Http\Controllers\Api\ApiController;
use Log;
use App\Custom\CustomFunctions;
use App\Jobs\MatCompInsert;
use App\Models\MatComp;

class MaterialLoadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        /* $model_id = modelSMT::where('code',$request->input('model_id'))->first(); */
        $line_id = $mach_type->line->linename->id;
        $model = modelSMT::where('lines','LIKE','%"'.$line_id.'"%')->first();
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

        // Check duplicate
        $dup =  MatLoadModel::where('ReelInfo','LIKE',"%".CustomFunctions::getQrData($request->input('reelInfo'),'RID')."%")
                                ->latest('id')
                                ->first();
        if($dup){
            if($dup->machine_id == $mach_type && $dup->table_id == $table_id && $dup->mounter_id == $request->input('feeder_slot') && $dup->pos_id == $request->input('position')){
                return [
                    'type' => 'error',
                    'message' => 'Reel Already Scanned.'
                ];
            }         
        }
        /* $dup = MatLoadModel::where('ReelInfo','LIKE',"%".CustomFunctions::getQrData($request->input('reelInfo'),'RID')."%")->first();                          
        
        if($dup){
            return [
                'type' => 'error',
                'message' => 'Reel Already Scanned.'
            ];
        } */
        
        /* $insrecord=new MatLoadModel();
        $insrecord->machine_id=$mach_type;
        $insrecord->model_id=$request->input('model_id');
        $insrecord->table_id=$table_id;
        $insrecord->mounter_id=$request->input('feeder_slot');
        $insrecord->pos_id=$request->input('position');
        $insrecord->component_id=$comp_id;
        $insrecord->order_id=$request->input('order_id');
        $insrecord->employee_id=$request->input('emp_id');
        $insrecord->ReelInfo=$request->input('reelInfo');
        $insrecord->results="MATCH";
        $insrecord->save(); */

        $insrecord=new MatLoadModel();
        $insrecord->machine_id=$mach_type;
        $insrecord->model_id=$model->id;
        $insrecord->table_id=$table_id;
        $insrecord->mounter_id=$request->input('feeder_slot');
        $insrecord->pos_id=$request->input('position');
        $insrecord->component_id=$comp_id;
        $insrecord->order_id=$request->input('order_id');
        $insrecord->employee_id=$request->input('emp_id');
        $insrecord->ReelInfo=$request->input('reelInfo');
        $insrecord->results="MATCH";
        /* $insrecord->save();   */      
        
        $req = [
            'machine_id' => $request->input('machine_id'),
            'new_PN' => $request->input('new_PN'),
            'position' => $request->input('position'),
            'feeder_slot' => $request->input('feeder_slot'),
            'comp_rid' => $request->input('comp_rid'),
            'comp_qty' => $request->input('comp_qty'),
            /* 'id' => $insrecord->id, */
            'model_id' => $model->id
        ];
        $matcomp_id = ApiController::insertmatcomp1($req);
        if($matcomp_id){
            $insrecord->save();      
            $mc = MatComp::find($matcomp_id);
            $mc->mat_load_id = $insrecord->id;
            $mt = $mc->materials;
            $sys_qty = 0;
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
        /* MatCompInsert::dispatch($req); */
        /* MatCompInsert::dispatch($req,$insrecord->id); */
        /* ApiController::insertmatcomp($request,$insrecord); */
        /* ApiController::insertmatcomp($request,$insrecord->id); */

       /*  $insrecord=new MatLoadModel();
        $insrecord->machine_id=$mach_type;
        $insrecord->model_id=$model_id;
        $insrecord->table_id=$table_id;
        $insrecord->mounter_id=$request->input('feeder_slot');
        $insrecord->pos_id=$request->input('position');
        $insrecord->component_id=$comp_id;
        $insrecord->order_id=$request->input('order_id');
        $insrecord->employee_id=$request->input('emp_id');
        $insrecord->ReelInfo=$request->input('reelInfo');
        $insrecord->results="MATCH";
        $insrecord->save(); */

        

        
        $running_mach = RunningOnMachine::where('machine_id',$mach_type)
                                        ->where('model_id',$model->id)
                                        ->where('table_id',$table_id)
                                        ->where('mounter_id',$request->input('feeder_slot'))
                                        ->where('pos_id',$request->input('position'))
                                        ->first();

        /* $running_mach = RunningOnMachine::where('machine_id',$mach_type)
                                        ->where('model_id',$model_id)
                                        ->where('table_id',$table_id)
                                        ->where('mounter_id',$request->input('feeder_slot'))
                                        ->where('pos_id',$request->input('position'))
                                        ->first();    */                             


        if($running_mach){            
            $RunUpdate = RunningOnMachine::find($running_mach->id);
            $RunUpdate->machine_id=$mach_type;
            $RunUpdate->model_id=$model->id;
            $RunUpdate->table_id=$table_id;
            $RunUpdate->mounter_id=$request->input('feeder_slot');
            $RunUpdate->pos_id=$request->input('position');
            $RunUpdate->component_id=$comp_id;
            $RunUpdate->order_id=$request->input('order_id');
            $RunUpdate->employee_id=$request->input('emp_id');
            $RunUpdate->datetime_update= date("Y-m-d");
            $RunUpdate->save();
            /* return "update"; */
        }
        else{
            $RunInsert=new RunningOnMachine();
            $RunInsert->machine_id=$mach_type;
            $RunInsert->model_id=$model->id;
            $RunInsert->table_id=$table_id;
            $RunInsert->mounter_id=$request->input('feeder_slot');
            $RunInsert->pos_id=$request->input('position');
            $RunInsert->component_id=$comp_id;
            $RunInsert->order_id=$request->input('order_id');
            $RunInsert->employee_id=$request->input('emp_id');
            $RunInsert->datetime_update= date("Y-m-d");
            $RunInsert->save();
            /* return "insert"; */
        }
        return [
            'type' => 'success',
            'message' => 'Data Recorded!: All inputs are correct.'
        ];

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
