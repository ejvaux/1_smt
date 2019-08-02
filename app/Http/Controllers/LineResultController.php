<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pcb;
use App\Models\PcbArchive;
use Carbon\Carbon;
use App\Http\Controllers\MES\model\LineName;

class LineResultController extends Controller
{
    public function index(Request $request)
    {
        if($request->input('date')){
            $date = $request->input('date');
        }
        else{
            $date = Date('Y-m-d');
        }
        /* $date = Date('Y-m-d'); */
        $date2 = Carbon::parse($date)->addDays(1);

        $lines = Pcb::select('line_id')->whereDate('created_at',$date)->groupBy('line_id')->get();
        if($request->input('line')){
            $lid = $request->input('line');
        }
        else{
            $lid = $lines{0}->line_id;
        }
        $linename = Linename::select('name')->where('id',$lid)->first();
        $in1 = Pcb::select('type')->whereDate('created_at',$date)->where('line_id',$lid)->where('shift',1)->where('type',0)->count();
        $out1 = Pcb::select('type')->whereDate('created_at',$date)->where('line_id',$lid)->where('shift',1)->where('type',1)->count();
        
        $in2 = Pcb::select('id')
            ->whereDate('created_at', $date)
            ->whereTime('created_at', '>=', '18:00:00')
            ->where('line_id',$lid)
            ->where('shift',2)
            ->where('type',0)->count() +
            Pcb::select('id')
            ->whereDate('created_at', $date2)
            ->whereTime('created_at', '<', '06:00:00')
            ->where('line_id',$lid)
            ->where('shift',2)
            ->where('type',0)->count();

        $out2 = Pcb::select('id')
            ->whereDate('created_at', $date)
            ->whereTime('created_at', '>=', '18:00:00')
            ->where('line_id',$lid)
            ->where('shift',2)
            ->where('type',1)->count() +
            Pcb::select('id')
            ->whereDate('created_at', $date2)
            ->whereTime('created_at', '<', '06:00:00')
            ->where('line_id',$lid)
            ->where('shift',2)
            ->where('type',1)->count();

        /* foreach ($lines as $line) {
            $in1 = Pcb::select('type')->whereDate('created_at',$date)->where('line_id',$line->line_id)->where('shift',1)->where('type',0)->count();
            $out1 = Pcb::select('type')->whereDate('created_at',$date)->where('line_id',$line->line_id)->where('shift',1)->where('type',1)->count();
            
            $in2 = Pcb::select('id')
                ->whereDate('created_at', $date)
                ->whereTime('created_at', '>=', '18:00:00')
                ->where('line_id',$line->line_id)
                ->where('shift',2)
                ->where('type',0)->count() +
                Pcb::select('id')
                ->whereDate('created_at', $date2)
                ->whereTime('created_at', '<', '06:00:00')
                ->where('line_id',$line->line_id)
                ->where('shift',2)
                ->where('type',0)->count();

            $out2 = Pcb::select('id')
                ->whereDate('created_at', $date)
                ->whereTime('created_at', '>=', '18:00:00')
                ->where('line_id',$line->line_id)
                ->where('shift',2)
                ->where('type',1)->count() +
                Pcb::select('id')
                ->whereDate('created_at', $date2)
                ->whereTime('created_at', '<', '06:00:00')
                ->where('line_id',$line->line_id)
                ->where('shift',2)
                ->where('type',1)->count();
        } */
        return view('pages.lr.lr',compact('date','date2','lid','linename','lines','in1','out1','in2','out2'));
    }

    public function resultTable(Request $request)
    {
        $date = $request->input('date');
        $date2 = Carbon::parse($date)->addDays(1);

        if(Carbon::parse('2019-08-01')->lessThan(Carbon::parse($date))){
            $lines = PcbArchive::select('line_id')->whereDate('created_at',$date)->groupBy('line_id')->get(); 
            if($request->input('line')){
                $lid = $request->input('line');
            }
            else{
                $lid = $lines{0}->line_id;
            }            
            $linename = Linename::select('name')->where('id',$lid)->first();
            $in1 = PcbArchive::select('type')->whereDate('created_at',$date)->where('line_id',$lid)->where('shift',1)->where('type',0)->count();
            $out1 = PcbArchive::select('type')->whereDate('created_at',$date)->where('line_id',$lid)->where('shift',1)->where('type',1)->count();
            
            $in2 = PcbArchive::select('id')
                ->whereDate('created_at', $date)
                ->whereTime('created_at', '>=', '18:00:00')
                ->where('line_id',$lid)
                ->where('shift',2)
                ->where('type',0)->count() +
                PcbArchive::select('id')
                ->whereDate('created_at', $date2)
                ->whereTime('created_at', '<', '06:00:00')
                ->where('line_id',$lid)
                ->where('shift',2)
                ->where('type',0)->count();
    
            $out2 = PcbArchive::select('id')
                ->whereDate('created_at', $date)
                ->whereTime('created_at', '>=', '18:00:00')
                ->where('line_id',$lid)
                ->where('shift',2)
                ->where('type',1)->count() +
                PcbArchive::select('id')
                ->whereDate('created_at', $date2)
                ->whereTime('created_at', '<', '06:00:00')
                ->where('line_id',$lid)
                ->where('shift',2)
                ->where('type',1)->count();
        }
        else{        
        $lines = Pcb::select('line_id')->whereDate('created_at',$date)->groupBy('line_id')->get(); 
        $lid = $request->input('line');
        $linename = Linename::select('name')->where('id',$lid)->first();
        $in1 = Pcb::select('type')->whereDate('created_at',$date)->where('line_id',$lid)->where('shift',1)->where('type',0)->count();
        $out1 = Pcb::select('type')->whereDate('created_at',$date)->where('line_id',$lid)->where('shift',1)->where('type',1)->count();
        
        $in2 = Pcb::select('id')
            ->whereDate('created_at', $date)
            ->whereTime('created_at', '>=', '18:00:00')
            ->where('line_id',$lid)
            ->where('shift',2)
            ->where('type',0)->count() +
            Pcb::select('id')
            ->whereDate('created_at', $date2)
            ->whereTime('created_at', '<', '06:00:00')
            ->where('line_id',$lid)
            ->where('shift',2)
            ->where('type',0)->count();

        $out2 = Pcb::select('id')
            ->whereDate('created_at', $date)
            ->whereTime('created_at', '>=', '18:00:00')
            ->where('line_id',$lid)
            ->where('shift',2)
            ->where('type',1)->count() +
            Pcb::select('id')
            ->whereDate('created_at', $date2)
            ->whereTime('created_at', '<', '06:00:00')
            ->where('line_id',$lid)
            ->where('shift',2)
            ->where('type',1)->count();
        }
            return view('includes.table.lrTable',compact('lines','linename','in1','out1','in2','out2'));
    }
}
