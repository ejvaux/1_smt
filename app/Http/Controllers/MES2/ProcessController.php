<?php

namespace App\Http\Controllers\MES2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
/* --Loading ModelName Path-- */
use App\Http\Controllers\MES2\model\Process;
use App\Http\Controllers\MES2\model\Divisionid;
use Auth;


class ProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* Requesting from model */
        /* Format : Variable = ModelName:: Eloquent; */
        $processes = Process::sortable()->get();
        $divisions = Divisionid::get();
        return view('mes2.process',compact('divisions','processes'));

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

        $this->validate($request, [
            'code'=> 'required',
            'name'=> 'required',
            'division_id'=> 'required',

    ]);

        $processes = new Process;
        $processes->code = $request->input('code');
        $processes->name = $request->input('name');
        $processes->division_id = $request->input('division_id');
        $processes->updated_by = Auth::user()->id;

        $processes->save();

        return redirect('/process')->with('success','Data Added successfully.');
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

        $process = Process::where('id',$id)->first();


        $process->code = $request->input('code');
        $process->name = $request->input('name');
        $process->division_id = $request->input('division_id');
        $process->updated_by = Auth::user()->id;


        $process->save();

        return redirect('/process')->with('success','Update successful.');
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

       /*  $Process= Process::where('id',$id)->delete(); */
       $Process= Process::find($id);
       $Process->delete();

        return redirect()->back()->with('success','Delete successful.');
    }
}
