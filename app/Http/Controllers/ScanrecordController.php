<?php

namespace App\Http\Controllers;

use App\scanrecordlist;
use Illuminate\Http\Request;

class ScanrecordController extends Controller
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
        $ins_screcord=new scanrecordlist();
        $ins_screcord->prodline_id=$request->input('sel_prodline');
        $ins_screcord->user_id=$request->input('sel_user');
        $ins_screcord->error_id=$request->input('sel_ecode');
        $ins_screcord->process_id=$request->input('sel_process');
        $ins_screcord->machine_id=$request->input('sel_machine');
        $ins_screcord->serial_number=$request->input('serialnum');
        $ins_screcord->scan_result=$request->input('sel_result');
        $ins_screcord->scan_type=$request->input('sel_scaninput');
        $ins_screcord->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\scanrecord  $scanrecord
     * @return \Illuminate\Http\Response
     */
    public function show(scanrecord $scanrecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\scanrecord  $scanrecord
     * @return \Illuminate\Http\Response
     */
    public function edit(scanrecord $scanrecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\scanrecord  $scanrecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, scanrecord $scanrecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\scanrecord  $scanrecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(scanrecord $scanrecord)
    {
        //
    }

    public function updateOUT(Request $request)
    {
        $IDtoUpdate = scanrecordlist::where('prodline_id','=',$request->input('sel_prodline'))
                                      ->where('process_id','=',$request->input('sel_process'))
                                      ->where('serial_number','=',$request->input('serialnum')) 
                                      ->first()
                                      ->id;
        /* ->where('scan_type','=','IN') */
        $SRecordUpdate = scanrecordlist::find($IDtoUpdate);
        $SRecordUpdate->prodline_id=$request->input('sel_prodline');
        $SRecordUpdate->user_id=$request->input('sel_user');
        $SRecordUpdate->error_id=$request->input('sel_ecode');
        $SRecordUpdate->process_id=$request->input('sel_process');
        $SRecordUpdate->machine_id=$request->input('sel_machine');
        $SRecordUpdate->serial_number=$request->input('serialnum');
        $SRecordUpdate->scan_result=$request->input('sel_result');
        $SRecordUpdate->scan_type=$request->input('sel_scaninput');
        $SRecordUpdate->save();

    }
}
