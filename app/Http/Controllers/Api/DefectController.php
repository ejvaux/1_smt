<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DefectMat;
use App\Models\Pcb;
use DateTime;

class DefectController extends Controller
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
        $e = DefectMat::where('id',$id)->first();
        if($request->input('division_id') != ""){ $e->division_id = $request->input('division_id');}
        if($request->input('defect_id') != ""){ $e->defect_id = $request->input('defect_id');}
        if($request->input('defect_type_id') != ""){ $e->defect_type_id = $request->input('defect_type_id');}
        if($request->input('process_id') != ""){ $e->process_id = $request->input('process_id');}
        if($request->input('line_id') != ""){ $e->line_id = $request->input('line_id');}
        if($request->input('shift') != ""){ $e->shift = $request->input('shift');}
        if($request->input('employee_id') != ""){ $e->employee_id = $request->input('employee_id');}
                       
        if($e->save()){
            return redirect()->back()->with('success','Data Updated Successfully.');
        }
        else{
            return redirect()->back()->with('error','Updating Failed.');
        }
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
        /* if($request->input('product_number') != ""){ $c->product_number = $request->input('product_number');} */
    }
    public function tempstore(Request $request)
    {
        $request->validate([
            'serial_number' => 'string|required',
            'division_id' => 'integer|required',
            'defect_id' => 'integer|required',
            'defect_type_id' => 'integer|required',
            'process_id' => 'integer|required',
            'line_id' => 'integer|required',
            'employee_id' => 'integer|required',
        ]);
        
        if($a = Pcb::where('serial_number',$request->input('serial_number'))->first()){
            if($a->heat <= 6){
                $a->heat = $a->heat + 1;
                $a->defect = 1;
            }
            else{
                $a->heat = $a->heat + 1;
                return redirect()->back()->with('error','Max Heat Cycles Reached!');
            }
        }
        else{
            $a = new Pcb;
            $a->serial_number = $request->input('serial_number');
            $a->defect = 1;
            $a->heat = 1;
        }
        
        if($a->save())
        {
            $date = Date('H:i');
            if($date > '05:59' && $date < '18:00'){
                $shift = 1;
            }
            else if($date >= '18:00' || $date < '06:00'){
                $shift = 2;
            }
            else{
                $shift = 0;
            }
            $b = new DefectMat;
            $b->pcb_id = $a->id;
            $b->division_id = $request->input('division_id');
            $b->defect_id = $request->input('defect_id');
            $b->defect_type_id = $request->input('defect_type_id');
            $b->process_id = $request->input('process_id');            
            $b->line_id = $request->input('line_id');
            $b->shift = $shift;
            $b->employee_id = $request->input('employee_id');
            $b->repair = 0;
            if($b->save())
            {
                if($a->heat == 7){
                    return redirect()->back()->with('success','Data Saved Successfully. Max Heat Cycles Reached!');
                }
                else{
                    return redirect()->back()->with('success','Data Saved Successfully.');
                }                
            }
            else
            {
                return redirect()->back()->with('error','Saving Defect Material Failed.');
            }
        }
        else
        {
            return redirect()->back()->with('error','Saving Serial Number Failed.');
        }
        /* return redirect()->back()->with('success','TEST'); */
    }
    public function repairdef(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'string|required',
            'repaired_by' => 'integer|required',
        ]);
        $e = DefectMat::where('id',$id)->first();
        $e->remarks = $request->input('remarks');
        $e->repair_by = $request->input('repaired_by');
        $e->repair = 1;
        $e->repaired_at = Date('Y-m-d H:i:s');
        
        if($e->save()){
            return redirect()->back()->with('success','Data Updated Successfully.');
        }
        else{
            return redirect()->back()->with('error','Updating Failed.');
        }
    }
}
