<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pcb;
use App\Models\MatComp;

class SnReelController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.snrl.sr'/* ,compact('jos') */);
    }
    public function loadreel(Request $request){
        $reels = array();
        $mid = array();
        $bot = Pcb::where('serial_number',$request->input('sn'))->where('type',0)->where('div_process_id',1)->orderBy('id','DESC')->first();        
        $top = Pcb::where('serial_number',$request->input('sn'))->where('type',0)->where('div_process_id',2)->orderBy('id','DESC')->first();
        if($bot){
            array_push($mid, $bot->mat_comp_id);
        }
        if($top){
            array_push($mid, $top->mat_comp_id);
        }
        
        $rs = MatComp::whereIn('id',$mid)->get();
        foreach ($rs as $r) {
            /* $reels = $r->materials; */
            array_push($reels, $r->materials);
        }
        /* $reels = $r1->materials;
        array_push($reels,$r2); */
        /* $reels = MatComp::whereIn('id', $pcbs)->get(); */
        /* dd($reels); */
        /* return json_encode($reels); */
        /* return json_encode($rs); */
        return view('includes.table.sntTable',compact('reels'));
    }
}
