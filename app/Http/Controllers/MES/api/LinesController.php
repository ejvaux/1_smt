<?php

namespace App\Http\Controllers\MES\api;

use App\Http\Controllers\MES\model\Line;
use App\Http\Controllers\MES\model\LineName;
use App\Http\Controllers\MES\model\Machine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LinesController extends Controller
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
            'line_name_id' => 'integer|required',
            'machine_id' => 'integer|required',
        ]);
        $code = LineName::where('id',$request->input('line_name_id'))->pluck('name')->first();
        $c = new Line;
        $c->code = $code;
        $c->line_name_id = $request->input('line_name_id');
        $c->machine_id = $request->input('machine_id');        

        if($c->save()){
            // update line in machine list
            $m = Machine::where('id',$request->input('machine_id'))->first();
            $m->line_id = $c->id;
            if($m->save()){
                return redirect()->back()->with('success','Line - Machine Saved Successfully.');
            }
            else{
                return redirect()->back()->with('error','Updating Machine Failed.');
            }          
        }
        else{
            return redirect()->back()->with('error','Saving Line - Machine Structure Failed.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Controllers\MES\model\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function show(Line $line)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Http\Controllers\MES\model\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function edit(Line $line)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Controllers\MES\model\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'code' => 'string|required',
            'machine_id' => 'integer|required',
        ]);
        
        $c = Line::where('id',$id)->first();

        if($request->input('code') != ""){ $c->code = $request->input('code');}
        if($request->input('machine_id') != ""){ $c->machine_id = $request->input('machine_id');}

        if($c->save()){
            return redirect()->back()->with('success','Data Updated Successfully.');
        }
        else{
            return redirect()->back()->with('error','Update Failed.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Controllers\MES\model\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Line::where('id',$id)->delete()){
            return redirect()->back()->with('success','Data Deleted Successfully.');
        }
        else{
            return redirect()->back()->with('error','Update Failed.');
        }
    }
}
