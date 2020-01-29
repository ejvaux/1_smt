<?php

namespace App\Http\Controllers\MES\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MES\model\Process;

class ProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->input('text') == ''){
            $processes = Process::orderBy('id','DESC')->paginate(20);
        }
        else{
            $s = $request->input('text');
            $processes = Process::where('name','like','%'.$s.'%')->orwhere('code','like','%'.$s.'%')->orderBy('id','DESC')->paginate(20);
        }
        return view('mes.inc.table.prTable',compact('processes'));
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
        $p = new Process;
        $p->code = $request->input('code');
        $p->name = $request->input('name');
        $p->division_id = $request->input('division_id');
        $p->updated_by = $request->input('user_id');
        if($p->save()){
            return [
                'type' => 'success',
                'message' => 'Data successfully saved.'
            ];
        }
        /* return [
            'type' => 'error',
            'message' => 'TEST'
        ]; */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Process::where('division_id',$id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {        
        return Process::where('id',$id)->first();
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
        $p = Process::where('id',$id)->first();
        $p->code = $request->input('code');
        $p->name = $request->input('name');
        $p->division_id = $request->input('division_id');
        $p->updated_by = $request->input('user_id');
        if($p->save()){
            return [
                'type' => 'success',
                'message' => 'Data successfully saved.'
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
        if(Process::where('id',$id)->delete())
        {
            return [
                'type' => 'success',
                'message' => 'Data Successfully Deleted!'
            ];
        }
        /* return [
            'type' => 'success',
            'message' => 'Data Successfully Deleted!'
        ]; */
    }
}
