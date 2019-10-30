<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pcb;
use App\Models\PcbArchive;
use Carbon\Carbon;
use App\Http\Controllers\MES\model\LineName;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LineExport;

class LineResultController extends Controller
{
    public function index(Request $request)
    {
        $lines = Linename::whereIn('division_id',[2,18])->get();
        $date = Date('Y-m-d');        
        return view('pages.lr.lr',compact(
            'date',
            'lines'
        ));
    }

    public function resultTable(Request $request)
    {
        $line = $request->input('line');        
        $date = $request->input('date').' 06:00:00';
        $date2 = Carbon::parse($date)->addDays(1);
        $date3 = $request->input('date').' 18:00:00';

        $pcb = PcbArchive::where('line_id',$line)
                    ->where('created_at','>=',$date)
                    ->where('created_at','<',$date2);
        $pcbs = Pcb::where('line_id',$line)
                    ->where('created_at','>=',$date)
                    ->where('created_at','<',$date2)
                    ->union($pcb)
                    ->get();       
        
        // DAY
        $dbi = $pcbs->filter(function ($value) use($date,$date3){
                    return $value->div_process_id == 1 && $value->type == 0 
                    && $value->created_at >= $date
                    && $value->created_at < $date3;
                })->count();
        $dbo = $pcbs->filter(function ($value) use($date,$date3){
                    return $value->div_process_id == 1 && $value->type == 1 
                    && $value->created_at >= $date
                    && $value->created_at < $date3;
                })->count();
        $dti = $pcbs->filter(function ($value) use($date,$date3){
                    return $value->div_process_id == 2 && $value->type == 0 
                    && $value->created_at >= $date
                    && $value->created_at < $date3;
                })->count();
        $dto = $pcbs->filter(function ($value) use($date,$date3){
                    return $value->div_process_id == 2 && $value->type == 1 
                    && $value->created_at >= $date
                    && $value->created_at < $date3;
                })->count();
        $ddi = $pcbs->filter(function ($value) use($date,$date3){
                    return $value->div_process_id == 5 && $value->type == 0 
                    && $value->created_at >= $date
                    && $value->created_at < $date3;
                })->count();
        $ddo = $pcbs->filter(function ($value) use($date,$date3){
                    return $value->div_process_id == 5 && $value->type == 1 
                    && $value->created_at >= $date
                    && $value->created_at < $date3;
                })->count();

        // Night
        $nbi = $pcbs->filter(function ($value) use($date2,$date3){
                    return $value->div_process_id == 1 && $value->type == 0 
                    && $value->created_at >= $date3
                    && $value->created_at < $date2;
                })->count();
        $nbo = $pcbs->filter(function ($value) use($date2,$date3){
                    return $value->div_process_id == 1 && $value->type == 1 
                    && $value->created_at >= $date3
                    && $value->created_at < $date2;
                })->count();
        $nti = $pcbs->filter(function ($value) use($date2,$date3){
                    return $value->div_process_id == 2 && $value->type == 0 
                    && $value->created_at >= $date3
                    && $value->created_at < $date2;
                })->count();
        $nto = $pcbs->filter(function ($value) use($date2,$date3){
                    return $value->div_process_id == 2 && $value->type == 1 
                    && $value->created_at >= $date3
                    && $value->created_at < $date2;
                })->count();
        $ndi = $pcbs->filter(function ($value) use($date2,$date3){
                    return $value->div_process_id == 5 && $value->type == 0 
                    && $value->created_at >= $date3
                    && $value->created_at < $date2;
                })->count();
        $ndo = $pcbs->filter(function ($value) use($date2,$date3){
                    return $value->div_process_id == 5 && $value->type == 1 
                    && $value->created_at >= $date3
                    && $value->created_at < $date2;
                })->count();

        $linename = Linename::where('id',$line)->pluck('name')->first();

        return view('includes.table.lrTable',compact(
            'pcbs',
            'linename',
            'dbi',
            'dbo',
            'dti',
            'dto',
            'ddi',
            'ddo',
            'nbi',
            'nbo',
            'nti',
            'nto',
            'ndi',
            'ndo'
        ));
    }

    public function exportlineresult(Request $request)
    {
        $filename = LineName::where('id',$request->input('line'))->pluck('name')->first() .'_'. Date('Y-m-d_his');
        
        return Excel::download(new LineExport(
            $request->input('line'),
            $request->input('type'),
            $request->input('fromdate'),
            $request->input('todate'),
            $request->input('fromtime'),
            $request->input('totime')
        ), $filename.'.xlsx');
    }
}
