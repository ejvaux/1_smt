<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrder;
use App\Models\Pcb;
use App\Models\PcbArchive;
use App\Models\DivProcess;
use App\Http\Controllers\MES\model\LineName;
use Carbon\Carbon;

class ResultsController extends Controller
{
    public function index(Request $request)
    {
        $dprocs = DivProcess::all();
        $wts = [];
        $woi = '';
        if($request->input('wo')){
            $woi = $request->input('wo');
            if(stripos($request->input('wo'), ',')){
                $wos = explode(",",$request->input('wo'));
            }
            else{
                $wos = explode(" ",$request->input('wo'));
            }
            foreach ($wos as $wo) {
                $total = 0;
                $jos = WorkOrder::where('SALES_ORDER',$wo)->get();
                foreach ($jos as $jo) {
                    $total += Pcb::where('jo_id',$jo->ID)->where('div_process_id',$request->input('pid'))->where('type',$request->input('type'))->whereNull('work_order')->count();
                }
                $total += Pcb::where('work_order',$wo)->where('div_process_id',$request->input('pid'))->where('type',$request->input('type'))->whereNotNull('work_order')->count();
                $wts[$wo] = $total;
                
            }
        }
        /* return dd($wts); */
        return view('pages.results.wo',compact('wts','dprocs','woi'));
    }
    public function summary(Request $request)
    {
        $lines = Linename::whereIn('division_id',[2,18])->get();
        $date = Date('Y-m-d');  
        return view('pages.results.lsr',compact(
            'date',
            'lines'
        ));
    }
    public function getSummary(Request $request)
    {
        $date = $request->input('date').' 06:00:00';
        $date2 = Carbon::parse($date)->addDays(1);
        $date3 = $request->input('date').' 18:00:00';

        $lines = Linename::whereIn('division_id',[2,18])->get();

        $pcb = PcbArchive::where('created_at','>=',$date)
                        ->where('created_at','<',$date2);
        $pcbs = Pcb::where('created_at','>=',$date)
                    ->where('created_at','<',$date2)
                    ->union($pcb)
                    ->get();

        foreach ($lines as $line) {            
            $lr[$line['name']] = $pcbs->filter(function ($value) use($line){
                                        return $value->line_id == $line['id'] && $value->type == 1;
                                    })->count();
        }
        $results = [
            'date' => $request->input('date'),
            'total' => $lr
        ];
        /* return $date; */
        return $results;
    }
}
