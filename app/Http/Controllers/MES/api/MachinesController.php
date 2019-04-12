<?php

namespace App\Http\Controllers\MES\api;

use App\Http\Controllers\MES\model\Machine;
use App\Http\Controllers\MES\model\MachineType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MachinesController extends Controller
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
        $request->validate([
            'machine_type_id' => 'integer|required'
        ]);

        $cc = Machine::where('machine_type_id',$request->input('machine_type_id'))->orderBy('id','DESC')->pluck('code')->first();
        $c = substr($cc,6,2)+1;
        if($c < 10){
            $c = '0'.$c;
        }
        $t = MachineType::where('id',$request->input('machine_type_id'))->first();
        $m = new Machine;
        $m->code = $t->name.'-'.$c;
        $m->barcode = $t->name.$c;
        $m->machine_type_id = $request->input('machine_type_id');
        $m->line_id = 0;
        if($m->save()){
            return redirect()->back()->with('success','Machine Saved Successfully.<br><b>Machine code: '.$t->name.'-'.$c.'</b>');
        }
        else{
            return redirect()->back()->with('error','Saving Failed.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Controllers\MES\model\Machine  $machine
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Http\Controllers\MES\model\Machine  $machine
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
     * @param  \App\Http\Controllers\MES\model\Machine  $machine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Controllers\MES\model\Machine  $machine
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Machine::where('id',$id)->delete()){
            return redirect()->back()->with('success','Data Deleted Successfully.');
        }
        else{
            return redirect()->back()->with('error','Update Failed.');
        }
    }
}
