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
use Response;

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
        
        $insrecord=new MatLoadModel();
        $insrecord->machine_id=$mach_type;
        $insrecord->model_id=$request->input('model_id');
        $insrecord->table_id=$table_id;
        $insrecord->mounter_id=$request->input('feeder_slot');
        $insrecord->pos_id=$request->input('position');
        $insrecord->component_id=$comp_id;
        $insrecord->employee_id=$request->input('emp_id');
        $insrecord->results="MATCH";
        $insrecord->save();

        

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
