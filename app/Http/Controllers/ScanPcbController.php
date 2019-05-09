<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Defect;
use App\Models\DefectMat;
use App\Models\Division;
use App\Models\Process;
use App\Models\DivProcess;
use App\Models\Pcb;
use App\Models\DefectType;
use App\Models\WorkOrder;
use App\Http\Controllers\MES\model\LineName;
use App\Http\Controllers\MES\model\Employee;

class ScanPcbController extends Controller
{
    public function __construct()
    {
        $this->divisions = Division::all();
        $this->linenames = LineName::all();
        $this->defects = Defect::all();
        $this->processes = Process::all();
        $this->employee = Employee::all();
        $this->defect_types = DefectType::all();
        $this->lines = LineName::all();
        $this->divprocesses = DivProcess::all();
    }

    public function index(Request $request)
    {
        $date1 = Date('Y-m-d');
        ($request->input('div_id') != '' ? $div_id = $request->input('div_id') : $div_id = 0);
        ($request->input('div_proc_id') != '' ? $div_proc_id = $request->input('div_proc_id') : $div_proc_id = 0);
        ($request->input('line_id') != '' ? $line_id = $request->input('line_id') : $line_id = 0);

        $type = $request->input('type');
        $divisions = $this->divisions;
        $divprocesses = $this->divprocesses;
        $sel_division = Division::where('DIVISION_ID',$div_id)->first();
        $sel_div_process = DivProcess::where('id',$div_proc_id)->first();
        $sel_line = LineName::where('id',$line_id)->first();

        $workorders = WorkOrder::where('JOB_ORDER_NO','LIKE',"{$sel_division->SAP_DIVISION_CODE}%")->where('DATE_',$date1)->paginate('100');
        
        return view('pages.scan.sp',compact(
            'date1',
            'workorders',
            'divisions',
            'processes',
            'type',
            'divprocesses',
            'sel_division',
            'sel_div_process',
            'sel_line'
        ));
    }
    public function scansetting(Request $request)
    {
        $data="";
        $divisions = $this->divisions;
        
        return view('includes.scansetting',compact(
            'divisions'
        ));
    }    
}
