<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pcb;
use Carbon\Carbon;

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
        $date2 = Carbon::parse($date)->addDays(1);
        $in1 = 0;
        $out1 = 0;
        $in2 = 0;
        $out2 = 0;
        $lines = Pcb::select('line_id')->whereDate('created_at',$date)->groupBy('line_id')->get();
        foreach ($lines as $line) {
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
                ->where('type',0)->count()
                ;

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
                ->where('type',1)->count()
                ;
            
            /* $in2 = Pcb::select('id')
                ->where(function ($query) use ($date,$line) {
                    $query->whereDate('created_at',$date)
                    ->whereTime('created_at', '>=', '18:00:00')
                    ->where('line_id',$line->line_id)
                    ->where('shift',2);
                })
                ->orwhere(function ($query) use ($date2,$line) {
                    $query->whereDate('created_at',$date2)
                    ->whereTime('created_at', '<', '06:00:00')
                    ->where('line_id',$line->line_id)
                    ->where('shift',2);
                })
                ->where('type',0)->count(); */

            /* $out2 = Pcb::select('id')
                ->where(function ($query) use ($date,$line) {
                    $query->whereDate('created_at',$date)
                    ->whereTime('created_at', '>=', '18:00:00')
                    ->where('line_id',$line->line_id)
                    ->where('shift',2);
                })
                ->orwhere(function ($query) use ($date2,$line) {
                    $query->whereDate('created_at',$date2)
                    ->whereTime('created_at', '<', '06:00:00')
                    ->where('line_id',$line->line_id)
                    ->where('shift',2);
                })
                ->where('type',1)->count(); */
        }
        return view('pages.lr.lr',compact('date','lines','in1','out1','in2','out2'));
    }
}
