<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Defect;
use App\Models\DefectMat;
use App\Models\Division;
use App\Models\Process;
use App\Models\Pcb;
use App\Models\DefectType;
use App\Exports\DefectMatsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\MES\model\LineName;
use App\Http\Controllers\MES\model\Employee;
use Carbon\Carbon;

class DefectController extends Controller
{
    public function __construct()
    {
        /* $this->middleware('auth'); */
        $this->divisions = Division::all();
        $this->linenames = LineName::whereIn('division_id',[2,18])->get();
        $this->defects = Defect::all();
        $this->processes = Process::all();
        $this->employee = Employee::all();
        $this->defect_types = DefectType::all();
    }

    public function index(Request $request)
    {   
        $t = $request->input('text');
        ($request->input('shift') != "" ? $shift = $request->input('shift') : $shift = '');
        ($request->input('sdate') != "" ? $dte = $request->input('sdate') : $dte = Date('Y-m-d'));
        $dte2 = Carbon::parse($dte)->addDays(1);
        if($t == ''){
            if($shift == ''){
                $defect_mats = DefectMat::sortable()
                            ->where(function ($query) use ($dte) {
                                $query->whereDate('created_at',$dte)
                                    ->where('shift', 1);
                            })
                            ->orwhere(function ($query) use ($dte) {
                                $query->whereDate('created_at',$dte)
                                    ->whereTime('created_at', '>=', '18:00:00')                                    
                                    ->where('shift', 2);
                            })
                            ->orwhere(function ($query) use ($dte2) {
                                $query->whereDate('created_at', $dte2)
                                    ->whereTime('created_at', '<', '06:00:00')                                    
                                    ->where('shift', 2);
                            })                            
                            ->orderBy('id','DESC')->paginate('20');
            }
            else{
                if($shift == 1){
                    $defect_mats = DefectMat::sortable()
                        ->whereDate('created_at',$dte)
                        ->where('shift', 1)
                        ->orderBy('id','DESC')
                        ->paginate('20');
                }
                else if ($shift == 2){
                    $defect_mats = DefectMat::sortable()
                        ->where(function ($query) use ($dte) {
                            $query->whereDate('created_at',$dte)
                                ->whereTime('created_at', '>=', '18:00:00')                                    
                                ->where('shift', 2);
                        })
                        ->orwhere(function ($query) use ($dte2) {
                            $query->whereDate('created_at', $dte2)
                                ->whereTime('created_at', '<', '06:00:00')                                    
                                ->where('shift', 2);
                        })                            
                        ->orderBy('id','DESC')->paginate('20');
                }
            }
            
        }
        else{
            $pcb = Pcb::where('serial_number',$t)->pluck('id');
            $defect_mats = DefectMat::sortable()->whereIN('pcb_id',$pcb)->orderBy('id','DESC')->paginate('20');         
        }
        
        $divisions = $this->divisions;
        $lines = $this->linenames;
        $defects = $this->defects;
        $processes = $this->processes;
        $defect_types = $this->defect_types;
        
        if($request->input('table')){
            return view('includes.table.dsTable',compact(
                'shift',
                'defect_mats',
                'divisions',
                'lines',
                'defects',
                'processes',
                'dte',
                'defect_types'
            ));
        }
        else{
            return view('pages.defect.ds',compact(
                'shift',
                'defect_mats',
                'divisions',
                'lines',
                'defects',
                'processes',
                'dte',
                'defect_types'
            ));
        }        
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
    public function exportdefectmats(Request $request)
    {        
        $filename = 'DEFECTS_';
        if($request->input('date_from') == $request->input('date_to')){
            $filename .= $request->input('date_from').'_'.Date('His');
        }
        else{
            $filename .= $request->input('date_from').'_to_'.$request->input('date_to').'_'.Date('His');
        }
        return Excel::download(new DefectMatsExport(
            $request->input('date_from'),
            $request->input('date_to'),
            $request->input('status'),
            $request->input('line'),
            $request->input('shift')
        ), $filename.'.xlsx');
    }
}
