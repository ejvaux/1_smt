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
            'line_id' => 'integer|required',
            'table_id' => 'integer|required',
            'mounter_id' => 'integer|required',
            'pos_id' => 'integer|required',
            'order_id' => 'integer|required',
            'component_id' => 'integer|required',
        ]);

        $f = new Feeder;
        $f->model_id = $request->input('model_id');
        $f->machine_type_id = $request->input('machine_type_id');
        $f->line_id = $request->input('line_id');
        $f->table_id = $request->input('table_id');
        $f->mounter_id = $request->input('mounter_id');
        $f->pos_id = $request->input('pos_id');
        $f->order_id = $request->input('order_id');
        $f->component_id = $request->input('component_id');

        $m = ModName::find($request->input('model_id'));
        $m->updated_by = $request->input('user_id');
        $m->touch();

        if($f->save()){
            return redirect()->back()->with([
                'success' => 'Data Saved Successfully.',
                'Atbl' => $request->input('table_id')
            ]);
            
            /* return 'Data Saved Successfully.'; */
        }
        else{
            return redirect()->back()->with('error','Saving Failed.');
            /* return 'Saving Failed.'; */
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
            'model_id' => 'integer|required',
            'mounter_id' => 'integer|required',
            'pos_id' => 'integer|required',
            'order_id' => 'integer|required',
            'component_id' => 'integer|required',
            'user_id' => 'integer|required',
        ]);
        $uid = $request->input('user_id');
        $mid = $request->input('model_id');
        $f = Feeder::find($id);

        if($request->input('mounter_id') != ""){ $f->mounter_id = $request->input('mounter_id');}
        if($request->input('pos_id') != ""){ $f->pos_id = $request->input('pos_id');}
        if($request->input('order_id') != ""){ $f->order_id = $request->input('order_id');}
        if($request->input('component_id') != ""){ $f->component_id = $request->input('component_id');}

        $m = ModName::find(8);
        /* $m = ModName::where('id',$request->input('model_id'))->first(); */
        $m->updated_by = $uid;
        $m->touch();

        if($f->save()){
            return redirect()->back()->with([
                'success' => 'Component Updated Successfully.',
                'Atbl' => $request->input('table_id')
            ]);
            /* return 'Component Updated Successfully.'; */
        }
        else{
            return redirect()->back()->with('error','Update Failed.');
            /* return 'Update Failed.'; */
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $mid = Feeder::where('id',$id)->first(); 
        if(Feeder::where('id',$id)->delete()){
            $m = ModName::where('id',$mid->model_id)->first();
            $m->updated_by = $request->input('user_id');
            $m->touch();
            return redirect()->back()->with([
                'success' => 'Component Deleted Successfully.',
                'Atbl' => $mid->table_id
            ]);
            /* return 'Component Deleted Successfully.'; */
        }
        else{
            return redirect()->back()->with('error','Update Failed.');
            /* return 'Update Failed.'; */
        }
    }
    public function del_mount(Request $request)
    {
        /* Feeder::where('model_id',$id)->where('model_id',$id)->where('model_id',$id)->where('model_id',$id); */        
        if(Feeder::where('model_id',$request->input('model_id'))->where('machine_type_id',$request->input('machine_type_id'))->where('table_id',$request->input('table_id'))->where('mounter_id',$request->input('mounter_id'))->delete()){
            $m = ModName::find($request->input('model_id'));
            $m->updated_by = $request->input('user_id');
            $m->touch();
            return redirect()->back()->with([
                'success' => 'Mounter Deleted Successfully.',
                'Atbl' => $request->input('table_id')
            ]);
            /* return 'Mounter Deleted Successfully.'; */
        }
        else{
            return redirect()->back()->with('error','Update Failed.');
            /* return 'Update Failed.'; */
        }
        /* return $request->input('model_id') . '-' . $request->input('machine_type_id') . '-' . $request->input('table_id') . '-' . $request->input('mounter_id'); */
    }
    public function change_mount(Request $request)
    {
        /* $mts = Feeder::where('model_id',$request->input('model_id'))->where('machine_type_id',$request->input('machine_type_id'))->where('table_id',$request->input('table_id'))->where('mounter_id',$request->input('mounter_id_from'))->update(['mounter_id' => $request->input('mounter_id_to')]); */
        if(Feeder::where('model_id',$request->input('model_id'))->where('machine_type_id',$request->input('machine_type_id'))->where('table_id',$request->input('table_id'))->where('mounter_id',$request->input('mounter_id_from'))->update(['mounter_id' => $request->input('mounter_id_to')])){
            $m = ModName::find($request->input('model_id'));
            $m->updated_by = $request->input('user_id');
            $m->touch();
            return redirect()->back()->with([
                'success' => 'Mounter Changed Successfully.',
                'Atbl' => $request->input('table_id')                
            ]);
        }
        else{
            return redirect()->back()->with('error','Update Failed.');
        }
    }
    public function transfer_mount(Request $request)
    {
        if(Feeder::where('model_id',$request->input('model_id'))->where('machine_type_id',$request->input('machine_type_id'))->where('table_id',$request->input('table_id'))->where('mounter_id',$request->input('mounter_id'))->update(['table_id' => $request->input('table_id_to')])){
            $m = ModName::find($request->input('model_id'));
            $m->updated_by = $request->input('user_id');
            $m->touch();
            return redirect()->back()->with([
                'success' => 'Mounter Transferred Successfully.',
                'Atbl' => $request->input('table_id_to')
            ]);
        }
        else{
            return redirect()->back()->with('error','Update Failed.');
        }
    }
}
