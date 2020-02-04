<?php

namespace App\Http\Controllers\MES\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MES\model\ModName;

class ModelsController extends Controller
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
            'code' => 'string|required',
            'program_name' => 'string|required',
            'updated_by' => 'integer|required',
        ]);

        $v = ModName::where('code', $request->input('code'))->get();
        if($v->count() == 0){
            $m = new ModName;
            $m->code = $request->input('code');
            $m->program_name = $request->input('program_name');
            $m->updated_by = $request->input('updated_by');
            $m->version = 0;
            $m->lines = [];
            /* $m->save(); */
            if($m->save()){
                return redirect()->back()->with('success','Model Saved Successfully.');
            }
            else{
                return redirect()->back()->with('error','Saving Failed.');
            }
        }
        else{
            return redirect()->back()->with('error','The model already exists.');
        }
        
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
        if(ModName::find($id)->delete()){
            return redirect()->back()->with('success','Model Deleted Successfully.');
        }
    }
}
