<?php

namespace App\Http\Controllers\MES2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MES2\model\Qc;
use App\Models\Pcb;
use Carbon\Carbon;

class qcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = 0;
        if($request->input('date')){
            $date = $request->input('date');
        }
        else{
            $date = Date('Y-m-d');
        }
        if($request->input('sn')){
            $pcb = Pcb::where('serial_number',$request->input('sn'))->where('type',1)->orderBy('id','DESC')->first();
            $lots = Qc::where('id', $pcb->lot_id)->get();
        }
        elseif($request->input('sort')){
            $sort = $request->input('sort');
            $temp = Qc::whereDate('created_at', $date);

            switch ($sort) {
                case 1:
                    $lots = $temp->where('status',0)->where('qc_status',0)->get();                    
                    break;
                case 2:
                    $lots = $temp->where('status',1)->where('qc_status',0)->get();
                    break;
                case 3:
                    $lots = $temp->where('status',1)->where('qc_status',1)->get();
                    break;
                case 4:
                    $lots = $temp->where('status',1)->where('qc_status',2)->get();
                    break;
                default:
                    $lots = $temp->get();
            }
        }
        else{            
            $lots = Qc::whereDate('created_at', $date)->get();
        }

        /* return dd($lots); */
        return view('mes2.qc',compact('lots','date','sort'));       
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
        $qc->checked_by = $request->input('userid');
        $qc->date = Carbon::now();
        
        $qc->save();
        return redirect('qc')->with('success','Updated Successful');

    }
    public function updatenogood(Request $request)
    {
        //
        $id1=$request->input('id2');
        $qc = Qc::where('id',$id1)->first();
        
        $qc->qc_status = '2';
        $qc->checked_by = $request->input('userid');
        $qc->date = Carbon::now();
        $qc->save();
        
        return redirect('qc')->with('success','Updated Successful');

    }

    public function checklotdetails(Request $request)
    {
        $sns = Pcb::where('lot_id',$request->input('lot_id'))->get();
        $lot = Qc::where('id',$request->input('lot_id'))->pluck('number')->first();
        return view('mes2.inc.snmodal',compact('sns','lot'));
    }
}
