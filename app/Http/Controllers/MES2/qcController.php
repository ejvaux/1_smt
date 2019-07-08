<?php

namespace App\Http\Controllers\MES2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\MES2\model\Qc;
use App\Models\Pcb;



use Illuminate\Support\Carbon;

class qcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$date=Carbon::now()->toDateTimeString('yyyy/mm/dd');
        $Qcs = Qc::all();
        $Pcbs = Pcb::all();
        return view('mes2.qc',compact('Qcs','Pcbs'));
       
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
         //Getting the search textbox value

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
        //
    }

    public function searchdate(Request $request)
    {
        //$get='';
        $get = $request->input('Dateqc');
        $date=Carbon::now()->toDateTimeString();

        if($get ==null){
                    $Qcs = Qc::all();
                    $Pcbs = Pcb::all();
                    
        }
        else{
                if($get!=''){
                    
                    $Qcs = Qc::where('created_at',$get)->get();
                    //$Qcs = Qc::all();
                }
                else{
                    //$Qcs=[];
                    $Qcs = Qc::where('created_at','like','%'.$date.'%')->get();
                }
        }
        return view('mes2.qc',compact('Qcs','Pcbs'));
    }

    public function searchlot(Request $request)
    {
        //$get='';
        $get = $request->input('myInputLot');
        $date=Carbon::now()->toDateTimeString();
        

        if($get ==null){
                $Qcs = Qc::where('created_at','')->get();
                $Pcbs = Pcb::all();
        }
        else{
                if($get!=''){
                    
                    $Qcs = Qc::where('number',$get)->get();
                    //$Qcs = Qc::all();
                }
                else{
                    //$Qcs=[];
                    //$Qcs = Qc::where('created_at','like','%'.$date.'%')->get();
                }
        }
        return view('mes2.qc',compact('Qcs','Pcbs'));
    }

    public function updategood(Request $request)
    {
        //
        $id1=$request->input('id1');
        $qc = Qc::where('id',$id1)->first();

        
        $qc->qc_status = '1';
        
        $qc->save();
        return redirect('qc')->with('success','Marked as Good Lot');

    }
    public function updatenogood(Request $request)
    {
        //
        $id1=$request->input('id2');
        $qc = Qc::where('id',$id1)->first();
        
        $qc->qc_status = '2';
        
        $qc->save();
        
        return redirect('qc')->with('success','Marked as No Good Lot');

    }
}
