<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\RemoteInsert;
use App\Http\Controllers\MES\model\LineName;
use App\Models\Pcb;
use App\Models\WorkOrder;
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
    public function joborder()
    {
        $jos = WorkOrder::where(function ($query) {
                            $query->where('JOB_ORDER_NO','LIKE','2%')
                            ->orwhere('JOB_ORDER_NO','LIKE','8%');
                        })
                        ->whereDate('DATE_',Date('Y-m-d'))->get();
        return view('pages.overview.tables.joTable', compact('jos'));
    }
    public function workorder()
    {

    }
    public function sysOptimize()
    {
        $rc = \Artisan::call('optimize');
        return "Application Optimized";
    }
}
