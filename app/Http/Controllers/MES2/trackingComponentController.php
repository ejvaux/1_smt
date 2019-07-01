<?php

namespace App\Http\Controllers\MES2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\ProdLine;
use App\component;
use App\ProcessList;
use App\errorcodelist;
use App\modelSMT;
use App\LRPosition;
use App\mounter;
use App\employee;
use App\machine;
use App\lineSMT;
use App\Http\Controllers\MES\model\LineName;
use App\RunningOnMachine;
use Nexmo\Message\Shortcode\Alert;

class trackingComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Getting the search textbox value
        $get = $request->input('myInputComponent');
        //Initialize getID variable
        $getID='';
        //Cheking for null object
        if($get==null){
            $Feeders = RunningOnMachine::where('component_id','')->get();
        }
        else
        //Checking after null is detected
            $getID = component::where('product_number',$get)->first();{
            if($getID !=''){
                $Feeders = RunningOnMachine::where('component_id',$getID->id)->orderBy('id','desc')->get();
            }
            else{
                $Feeders = [];
            }
        }
        return view('mes2.trackingcomponent',compact('Feeders'));
        
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
        //
    }
}
