<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pcb;
use App\Models\PcbArchive;
use App\Models\MatComp;
use App\Models\MatSnComp;
use App\Exports\SnComponentsExport;
use App\Exports\PnRidExport;
use App\Exports\ReelSnExport;
use App\Exports\SnPnExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\MES\model\Component;
use App\Http\Controllers\MES\model\LineName;
use App\Http\Controllers\MES\model\Position;
use App\Http\Controllers\MES\model\Modname;
use App\Models\WorkOrder;
use App\Custom\CustomFunctions;

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
        $reels = [];
        $mid = array();

        $archive = PcbArchive::where('serial_number',$request->input('sn'))->whereNotNull('mat_comp_id')->whereiN('div_process_id',[1,2])->orderBy('id','DESC');
        $pcbs = Pcb::where('serial_number',$request->input('sn'))->whereNotNull('mat_comp_id')->whereiN('div_process_id',[1,2])->orderBy('id','DESC')
                        ->union($archive)
                        ->get();
        
        if($pcbs && $pcbs->count() != 0){
            foreach ($pcbs as $pcb) {
                array_push($mid, $pcb->mat_comp_id);
            }            
            $sn = $request->input('sn');
        }
        $rs = MatComp::whereIn('id',$mid)->get();
        $reels = $rs;
        
        return view('includes.table.sntTable',compact('reels','sn'));        
    }
    public function loadsn(Request $request)
    {
        $rid = $reel = $request->input('rid');
        if (strpos($rid,':') !== false) {            
            $rid = $reel = CustomFunctions::getQrData($rid,'RID');
        }
        $cid = MatSnComp::where('RID',$rid)->pluck('component_id')->first();
        $pn = Component::where('id',$cid)->pluck('product_number')->first();
        $total = 1;
        $pcbs = [];
        $serials = MatSnComp::where('RID',$rid)->get();
        foreach ($serials as $serial) {
            $matcomp = Matcomp::where('id',$serial->mat_comp_id)->pluck('materials')->first();
            foreach ($matcomp as $cmp => $prop) {
                if(isset($prop['component_id'])){
                    if($prop['component_id'] == $serial->component_id){
                        $mach = $prop['machine'];
                        $fdr = $prop['feeder'];
                        $pos = Position::where('id',$prop['position'])->pluck('name')->first();
                        break;
                    }
                }
                else{
                    if($cmp == $serial->component_id){
                        $mach = $prop['machine'];
                        $fdr = $prop['feeder'];
                        $pos = Position::where('id',$prop['position'])->pluck('name')->first();
                        break;
                    }
                }                
            }
            $prog = Modname::where('id',$serial->model_id)->pluck('program_name')->first();            
            foreach ($serial->sn as $key) {
                /* $pcb = Pcb::where('serial_number',$key)->where('mat_comp_id',$serial->mat_comp_id)->first();
                if(!$pcb){
                    $pcb = PcbArchive::where('serial_number',$key)->where('mat_comp_id',$serial->mat_comp_id)->first();
                } */
                $pcb = Pcb::where('serial_number',$key)->where('line_id',$serial->line_id)->whereNotNull('mat_comp_id')->first();
                if(!$pcb){
                    $pcb = PcbArchive::where('serial_number',$key)->where('line_id',$serial->line_id)->first();
                }
                if($pcb){                    
                    if(!$pcb->work_order){
                        $wo = WorkOrder::where('ID',$pcb->jo_id)->pluck('SALES_ORDER')->first();
                    }
                    else{
                        $wo = $pcb->work_order;
                    }
                    $pcbs[] = [
                        'wo' => $wo,
                        'sn' => $pcb->serial_number,
                        'rid' => $serial->RID,
                        'pn' => $pn,
                        'dt' => $pcb->created_at,
                        'prog' => $prog,
                        'mach' => CustomFunctions::getmachcode($mach),
                        'tb' => CustomFunctions::getmachtable($mach),
                        'fdr' => $fdr,
                        'pos' => $pos,
                        'jo' => $pcb->jo_number,
                        'emp' => $pcb->employee->fname . ' ' . $pcb->employee->lname
                    ];
                }                
            }
        }
        /* return $pcbs; */
        return view('includes.table.reelTable',compact('pcbs','reel'));
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
        $snout = $request->input('sn');
        if(stripos($request->input('sn'), ',')){
            $sns = explode(",",$request->input('sn'));
        }
        else{
            $sns = explode(" ",$request->input('sn'));
        }
        
        $cid = $request->input('cid');
        $c = Component::where('id',$cid)->pluck('product_number')->first();
        $mats = MatSnComp::where('component_id',$cid)->get();

        foreach ($sns as $sn) {
            $bot = Pcb::select('created_at')->where('serial_number',$sn)                            
                ->where('div_process_id',1)
                ->where('type',1)
                ->pluck('created_at')
                ->first();
            $top = Pcb::select('created_at')->where('serial_number',$sn)                            
                ->where('div_process_id',2)
                ->where('type',1)
                ->pluck('created_at')
                ->first();
            if(!$bot){
                $bot = PcbArchive::select('created_at')->where('serial_number',$sn)                            
                ->where('div_process_id',1)
                ->where('type',1)
                ->pluck('created_at')
                ->first();
            }
            if(!$top){
                $top = PcbArchive::select('created_at')->where('serial_number',$sn)                            
                ->where('div_process_id',2)
                ->where('type',1)
                ->pluck('created_at')
                ->first();
            }
            $snrids[$sn]["BOT"] = $bot;               
            $snrids[$sn]["TOP"] = $top;
            $snrids[$sn]['PN'] = '';
            $snrids[$sn]['RID'] = '';
        }

        foreach ($mats as $mat) {
            foreach($mat->sn as $m){
                foreach ($sns as $sn) {
                    if($m == $sn){
                        $snrids[$sn]["PN"] = $c;               
                        $snrids[$sn]["RID"] = $mat->RID;
                    }
                }                
            }
        }

        /* foreach ($sns as $sn) {
            $snrids[$sn] = [
                "RID" => 'No Data',
                "line" => 'No Data'
                ];
            foreach ($mats as $mat) {
                foreach($mat->sn as $m){
                    if($m == $sn){
                        $snrids[$sn] = [
                                    "RID" => $mat->RID,
                                    "line" => LineName::where('id',$mat->line_id)->pluck('description')->first()
                                    ];
                    }                              
                }
            }
        } */

        if(count($snrids) > 0){
            $comp = Component::where('id',$cid)->pluck('product_number')->first();
        }
        /* return $snrids; */
        return view('includes.table.snpnTable',compact('snrids','comp','snout'));

        /* return json_encode($snrids); */
    }
    public function exportreel(Request $request)
    {
        return Excel::download(new SnComponentsExport($request->input('sn')), 'SN_'.$request->input('sn').'_'.Date('Y-m-d_His').'.xlsx');
    }
    public function exportpnrid(Request $request)
    {
        return Excel::download(new PnRidExport($request->input('pn')), 'PN_'.$request->input('pn').'_'.Date('Y-m-d_His').'.xlsx');
    }
    public function exportrlsn(Request $request)
    {
        return Excel::download(new ReelSnExport($request->input('reel')), 'RID_'.$request->input('reel').'_'.Date('Y-m-d_His').'.xlsx');
    }
    public function exportsnpn(Request $request)
    {
        return Excel::download(new SnPnExport($request->input('sn'),$request->input('cid')), 'SNPN_'.$request->input('cname').'_'.Date('Y-m-d_His').'.xlsx');
    }
}
