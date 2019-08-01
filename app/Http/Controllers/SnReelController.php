<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pcb;
use App\Models\PcbArchive;
use App\Models\MatComp;
use App\Exports\SnComponentsExport;
use Maatwebsite\Excel\Facades\Excel;

class SnReelController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.snrl.sr'/* ,compact('jos') */);
    }
    public function loadreel(Request $request)
    {
        $sn = '';
        $reels = array();
        $mid = array();
        $bot = Pcb::where('serial_number',$request->input('sn'))->where('type',0)->where('div_process_id',1)->orderBy('id','DESC')->first();
        $top = Pcb::where('serial_number',$request->input('sn'))->where('type',0)->where('div_process_id',2)->orderBy('id','DESC')->first();
        if(!$bot){
            $bot = PcbArchive::where('serial_number',$request->input('sn'))->where('type',0)->where('div_process_id',1)->orderBy('id','DESC')->first();
        }
        if(!$top){
            $top = PcbArchive::where('serial_number',$request->input('sn'))->where('type',0)->where('div_process_id',2)->orderBy('id','DESC')->first();
        }
        if($bot){
            array_push($mid, $bot->mat_comp_id);
            $sn = $request->input('sn');
        }
        if($top){
            array_push($mid, $top->mat_comp_id);
            $sn = $request->input('sn');
        }        
        $rs = MatComp::whereIn('id',$mid)->get();
        foreach ($rs as $r) {
            array_push($reels, $r->materials);
        }
        return view('includes.table.sntTable',compact('reels','sn'));
    }
    public function exportreel(Request $request)
    {
        return Excel::download(new SnComponentsExport($request->input('sn')), $request->input('sn').'_'.Date('Y-m-d_His').'.xlsx');
    }
}
