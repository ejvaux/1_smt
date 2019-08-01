<?php
namespace App\Http\Controllers\MES2;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


/* use App\Models\Pcb;
use App\Models\Division; */

use App\Models\Defect;
use App\Models\DefectMat;
use App\Models\Division;
use App\Models\Process;
use App\Models\DivProcess;
use App\Models\Pcb;
use App\Models\PcbArchive;
use App\Models\DefectType;
use App\Models\WorkOrder;
use App\Http\Controllers\MES\model\LineName;
use App\Http\Controllers\MES\model\Employee;


class trackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  
    public function index(Request $request)
    {

        $get = $request->input('myInputPCB');
        $Pcbs1 = Pcb::where('serial_number',$get)->orderBy('id')->get();
        $Pcbs2 = PcbArchive::where('serial_number',$get)->orderBy('id')->get();
        $Pcbs = $Pcbs1->merge($Pcbs2);
        /* if($Pcbs->count() == 0){
            $Pcbs = PcbArchive::where('serial_number',$get)->orderBy('id')->get();
        } */
        return view('mes2.tracking',compact('Pcbs'));

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
