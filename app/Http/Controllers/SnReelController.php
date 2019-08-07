<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pcb;
use App\Models\PcbArchive;
use App\Models\MatComp;
use App\Models\MatSnComp;
use App\Exports\SnComponentsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\MES\model\Component;
use App\Http\Controllers\MES\model\LineName;

class SnReelController extends Controller
{
    public function index(Request $request)
    {
        $mats = Component::all();
        return view('pages.snrl.sr',compact('mats'));
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
        if($bot && $bot->count() != 0){
            array_push($mid, $bot->mat_comp_id);
            $sn = $request->input('sn');
        }
        if($top && $top->count() != 0){
            array_push($mid, $top->mat_comp_id);
            $sn = $request->input('sn');
        }        
        $rs = MatComp::whereIn('id',$mid)->get();
        foreach ($rs as $r) {
            array_push($reels, $r->materials);
        }
        return view('includes.table.sntTable',compact('reels','sn'));
    }
    public function loadsn(Request $request)
    {
        $sns = [];
        $sntotal = 0;
        $serials = MatSnComp::where('RID',$request->input('rid'))->get();
        if($serials->count() != 0){
            foreach ($serials as $serial){
                foreach($serial->sn as $s){
                    $sns[] = $s;
                }
            }
            $reel = $request->input('rid');
            $sntotal = count($sns);
        }
        else{
            $reel = '';
        }
        /* return $sns; */
        return view('includes.table.reelTable',compact('sns','reel','sntotal'));
    }
    public function loadpn(Request $request)
    {
        $comp = '';
        $comp_id = Component::where('product_number',$request->input('pn'))->pluck('id')->first();
        $rids = MatSnComp::where('component_id',$comp_id)->groupBy('RID')->get();
        if($rids->count() != 0){
            $comp = $request->input('pn');
        }
        /* return $rids; */
        return view('includes.table.pnTable',compact('rids','comp'));
    }
    public function loadsnpn(Request $request)
    {
        $snrids = [];
        $comp = '';
        $sns = explode(",",$request->input('sn'));
        $cid = $request->input('cid');
        $mats = MatSnComp::where('component_id',$cid)->get();

        foreach ($mats as $mat) {
            foreach($mat->sn as $m){
                foreach ($sns as $sn) {
                    if($m == $sn){
                        $snrids[$sn] = [
                                    "RID" => $mat->RID,
                                    "line" => LineName::where('id',$mat->line_id)->pluck('description')->first()
                                    ];
                    }
                }                
            }
        }
        if(count($snrids) > 0){
            $comp = Component::where('id',$cid)->pluck('product_number')->first();
        }
        return view('includes.table.snpnTable',compact('snrids','comp'));

        /* return json_encode($snrids); */
    }
    public function exportreel(Request $request)
    {
        return Excel::download(new SnComponentsExport($request->input('sn')), $request->input('sn').'_'.Date('Y-m-d_His').'.xlsx');
    }
    public function exportsn(Request $request)
    {
        return Excel::download(new SnComponentsExport($request->input('sn')), $request->input('sn').'_'.Date('Y-m-d_His').'.xlsx');
    }
}
