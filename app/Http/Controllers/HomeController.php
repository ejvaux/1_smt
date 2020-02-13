<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\RemoteInsert;
use App\Http\Controllers\MES\model\LineName;
use App\Models\Pcb;
use App\Models\WorkOrder;
use App\Models\DefectMat;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /* $this->middleware('auth'); */
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /* return view('/home'); */
        return redirect('ov');
    }

    public function index2()
    {
        return view('/home');
        /* return view('pages.overview.ov'); */
    }
    public function overview()
    {
        return view('pages.overview.ov');
    }
    public function line()
    {
        $scans = [];
        $lines = LineName::whereIn('division_id', ['2','18'])->get();
        /* foreach ($lines as $line) {
            $scan = Pcb::where('type',1)->where('line_id', $line)->whereDate('created_at',Date('Y-m-d'))->latest('id')->first();
            if($scan){
                $scans[] = $scan;
            }
        } */
        $scans = Pcb::where('type',1)->whereDate('created_at',Date('Y-m-d'))->orderBy('line_id')->latest('id')->get()->unique('line_id');
        
        return view('pages.overview.tables.lineTable', compact('scans'));
    }
    public function defect(Request $request)
    {
        $defects = [];
        if($request->input('from') != '' && $request->input('to') != '')
        {
            $from = $request->input('from');
            $to = $request->input('to');
        }
        else
        { 
            $to = Date('Y-m-d');
            $from = Carbon::parse($to)->subWeek()->toDateString();
        }
        /* $def = DefectMat::where('created_at','>=',Carbon::parse($from)->addHours(6))->where('created_at','<',Carbon::parse($to)->addHours(6)->addDay())->get(); */
        $datee = Carbon::parse($from)->toDateString();
        while ($datee <= Carbon::parse($to)->toDateString()) {
            $def = DefectMat::where('created_at','>=',Carbon::parse($datee)->addHours(6))->where('created_at','<',Carbon::parse($datee)->addHours(6)->addDay())->get();
            $rep = $def->filter(function ($value) use ($request) {
                return $value->repair == 1;
            })->all();
            $defects[] = [
                'date' => $datee,
                'defect' => $def->count(),
                'repair' => count($rep)
            ];
            $datee = Carbon::parse($datee)->addDay()->toDateString();
        }
        /* $pcb->filter(function ($value) use ($request) {
            return $value->div_process_id == $request->div_process_id && $value->type == 1;
        })->all(); */
        /* return $defects; */
        return view('pages.overview.tables.defectTable', compact('defects','from','to'));
    }
    public function joborder()
    {
        $jos = WorkOrder::where(function ($query) {
                            $query->where('JOB_ORDER_NO','LIKE','2%')
                            ->orwhere('JOB_ORDER_NO','LIKE','8%');
                        })
                        ->whereDate('DATE_',Date('Y-m-d'))->get();
        return view('pages.overview.tables.joTable', compact('jos'));
    }
}
