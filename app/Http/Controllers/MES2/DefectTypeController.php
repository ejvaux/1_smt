<?php

namespace App\Http\Controllers\MES2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MES2\model\DefectType;

class DefectTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $defects = DefectType::all();
        return view('mes2.defecttype',compact('defects'));
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

    ]);

        $defects = new DefectType;
        $defects->code = $request->input('code');
        $defects->name = $request->input('name');


        $defects->save();

        return redirect('/defecttype')->with('success','Data Added successfully.');
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

        $defect = DefectType::where('id',$id)->first();

        
        $defect->code = $request->input('code');
        $defect->name = $request->input('name');
        $defect->save();

        return redirect('/defecttype')->with('success','Update successful.');
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

        $defect= DefectType::find($id);
        $defect->delete();

         return redirect()->back()->with('success','Delete successful.');
    }
}
