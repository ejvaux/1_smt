<?php

namespace App\Http\Controllers\MES\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MES\model\DefectType;

class DefectTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if($request->input('search')){
            $s = $request->input('search');
            $defect_types = DefectType::where('code','like','%'.$s.'%')->orWhere('name','like','%'.$s.'%')->orderBy('id','DESC')->paginate(20);
        }
        else{
            $defect_types = DefectType::orderBy('id','DESC')->paginate(20);
        }
        return view('mes.inc.table.dtTable',compact('defect_types'));
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
        $dt = new DefectType;
        $dt->code = $request->input('code');
        $dt->name = $request->input('name');
        if($dt->save()){
            return [
                'type' => 'success',
                'message' => 'Data Successfully Saved'
            ];
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
        return DefectType::where('id',$id)->first();
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
        $dt = DefectType::find($id);
        $dt->code = $request->input('code');
        $dt->name = $request->input('name');
        if($dt->save()){
            return [
                'type' => 'success',
                'message' => 'Data Successfully Updated'
            ];
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
        if(DefectType::find($id)->delete()){
            return [
                'type' => 'success',
                'message' => 'Data Successfully Deleted.'
            ];
        }
    }
}
