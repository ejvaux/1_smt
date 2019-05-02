<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Defect;
use App\Models\DefectMat;
use App\Models\Division;
use App\Models\Process;
use App\Models\Pcb;
use App\Http\Controllers\MES\model\LineName;
use App\Http\Controllers\MES\model\Employee;

class DefectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->divisions = Division::all();
        $this->linenames = LineName::all();
        $this->defects = Defect::all();
        $this->processes = Process::all();
        $this->employee = Employee::all();
    }

    public function index(Request $request)
    {   
        $t = $request->input('text');
        ($request->input('sdate') != "" ? $dte = $request->input('sdate') : $dte = Date('Y-m-d'));
        if($t == ''){            
            $defect_mats = DefectMat::sortable()->where('created_at','LIKE',"{$dte}%")->orderBy('id','DESC')->paginate('20');
        }
        else{
            $pcb = Pcb::where('serial_number',$t)->first();
            $defect_mats = DefectMat::sortable()->where('pcb_id',$pcb->id)->orderBy('id','DESC')->paginate('20');
            /* $defect_mats = DefectMat::whereHas('pcb', function ($query) use ($request) {
                $query->where('serial_number', 'like', "%{$request->text}%")->paginate('20');
            }); */
        }
        /* $defect_mats = DefectMat::sortable()->orderBy('id','DESC')->paginate('20'); */
        $divisions = $this->divisions;
        $linenames = $this->linenames;
        $defects = $this->defects;
        $processes = $this->processes;

        return view('pages.defect.ds',compact('defect_mats','divisions','linenames','defects','processes','dte'));
    }
    public function scanpinemp(Request $request)
    {
        if($request->input('check') == 1){
            if($name = Employee::where('pin',$request->input('pin'))->first())
            {
                return $name;
            }
            else{
                return 0;
            }
        }
        elseif($request->input('check') == 2){
            if($name = Employee::where('pin',$request->input('pin'))->where('repair',1)->first())
            {
                return $name;
            }
            else{
                return 0;
            }
        }
        
    }
}
