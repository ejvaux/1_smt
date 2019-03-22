<?php

namespace App\Http\Controllers\MES\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MES\model\Feeder;
use App\Http\Controllers\MES\model\ModName;

class FeedersController extends Controller
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
            'model_id' => 'integer|required',
            'machine_type_id' => 'integer|required',
            'table_id' => 'integer|required',
            'mounter_id' => 'integer|required',
            'pos_id' => 'integer|required',
            'order_id' => 'integer|required',
            'component_id' => 'integer|required',
        ]);

        $f = new Feeder;
        $f->model_id = $request->input('model_id');
        $f->machine_type_id = $request->input('machine_type_id');
        $f->table_id = $request->input('table_id');
        $f->mounter_id = $request->input('mounter_id');
        $f->pos_id = $request->input('pos_id');
        $f->order_id = $request->input('order_id');
        $f->component_id = $request->input('component_id');

        $m = ModName::find($request->input('model_id'));
        $m->updated_by = session('user_num');
        $m->touch();

        if($f->save()){
            return 'Data Saved Successfully.';
        }
        else{
            return 'Saving Failed.';
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
        $request->validate([
            'mounter_id' => 'integer|required',
            'pos_id' => 'integer|required',
            'order_id' => 'integer|required',
            'component_id' => 'integer|required',
        ]);
        
        $f = Feeder::find($id);

        if($request->input('mounter_id') != ""){ $f->mounter_id = $request->input('mounter_id');}
        if($request->input('pos_id') != ""){ $f->pos_id = $request->input('pos_id');}
        if($request->input('order_id') != ""){ $f->order_id = $request->input('order_id');}
        if($request->input('component_id') != ""){ $f->component_id = $request->input('component_id');}

        $m = ModName::find($request->input('model_id'));
        $m->updated_by = session('user_num');
        $m->touch();

        if($f->save()){
            return 'Component Updated Successfully.';
        }
        else{
            return 'Update Failed.';
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
        $mid = Feeder::where('id',$id)->pluck('model_id')->first();
        $m = ModName::find($mid);
        $m->updated_by = session('user_num');
        $m->touch();
        if(Feeder::where('id',$id)->delete()){

            return 'Component Deleted Successfully.';
        }
        else{
            return 'Update Failed.';
        }
    }    
}
