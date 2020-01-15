<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pcb;
use App\Models\PcbArchive;
use App\Models\DefectMat;
use App\Http\Controllers\MES\model\LineName;
use App\MatLoadModel;
use App\Http\Controllers\MES\model\Modname;
use App\Http\Controllers\MES\model\Feeder;
use App\Models\MatComp;
use App\Http\Controllers\MES\model\Line;
use DB;

class TrackingController extends Controller
{
    public function process(Request $request)
    {
        return view('pages.tracking.pt'/* ,compact(
            'shift',
            'defect_mats',
            'divisions',
            'lines',
            'defects',
            'processes',
            'dte',
            'defect_types'
        ) */);
    }
    public function checkprocess(Request $request)
    {
        $sn = $request->input('sn');        
        $bi = Pcb::select('defect')->where('serial_number',$sn)->where('div_process_id',1)->where('type',0)->first();
        $bo = Pcb::select('defect')->where('serial_number',$sn)->where('div_process_id',1)->where('type',1)->first();
        $ti = Pcb::select('defect')->where('serial_number',$sn)->where('div_process_id',2)->where('type',0)->first();
        $to = Pcb::select('defect')->where('serial_number',$sn)->where('div_process_id',2)->where('type',1)->first();

        if(!$bi){
            $bi = PcbArchive::select('defect')->where('serial_number',$sn)->where('div_process_id',1)->where('type',0)->first();
        }
        if(!$bo){
            $bo = PcbArchive::select('defect')->where('serial_number',$sn)->where('div_process_id',1)->where('type',1)->first();
        }
        if(!$ti){
            $ti = PcbArchive::select('defect')->where('serial_number',$sn)->where('div_process_id',2)->where('type',0)->first();
        }
        if(!$to){
            $to = PcbArchive::select('defect')->where('serial_number',$sn)->where('div_process_id',2)->where('type',1)->first();
        }

        return [
            'sn' => $sn,
            'bi' => $bi,
            'bo' => $bo,
            'ti' => $ti,
            'to' => $to
        ];

    }
    public function pcb(Request $request)
    {
        $ids = [];
        $get = $request->input('sn');
        if ($get) {
            $Pcbs1 = Pcb::where('serial_number',$get)->orderBy('serial_number')->orderBy('div_process_id','DESC')->orderBy('type','DESC')->get();
            $Pcbs2 = PcbArchive::where('serial_number',$get)->orderBy('serial_number')->orderBy('div_process_id','DESC')->orderBy('type','DESC')->get();
            $Pcbs = $Pcbs1->merge($Pcbs2);
            foreach ($Pcbs as $pcb) {
                $ids[] = $pcb->id;
            }
            $pcbds = DefectMat::whereIn('pcb_id',$ids)->get();
            return view('mes2.inc.pcbtablediv',compact('Pcbs','pcbds'));
        } else {
            return view('mes2.tracking');
        }
    }
    public function matloadlist()
    {
        $lines = LineName::where('division_id',2)->get();
        return view('pages.tracking.mll',compact('lines'));
    }
    public function loadlist(Request $request)
    {
        $mline = $request->line;
        $model_id = $mmodel = Modname::where('lines','LIKE','%"'.$request->line.'"%')->pluck('id')->first();
        $feeders = Feeder::where('model_id',$model_id)
                            ->where('line_id',$request->line)
                            ->where('table_id','!=',0)
                            ->groupBy('pos_id','mounter_id','table_id','machine_type_id')
                            /* ->orderBy('id','DESC') */
                            ->orderBy('machine_type_id')
                            ->orderBy('table_id')
                            ->orderBy('mounter_id')
                            ->orderBy('pos_id')
                            ->get();
        $f = MatComp::where('model_id', $model_id)->where('line_id',$request->line)->latest('id')->first();

        $mach = Line::where('line_name_id',$request->line)->pluck('machine_id');
        /* $mm = MatLoadModel::where('model_id',$model_id)
                                ->whereIN('machine_id',$mach)
                                ->groupBy('pos_id')
                                ->groupBy('mounter_id')
                                ->groupBy('table_id')
                                ->groupBy('machine_id')
                                ->orderBy('machine_id')
                                ->orderBy('table_id')
                                ->orderBy('mounter_id')
                                ->orderBy('pos_id')                                
                                ->get(); */

        return view('includes.table.mlTable',compact('model_id','feeders','f'/* ,'mm' */,'mline','mmodel'));
    }
    public function matcompdel(Request $request)
    {
        $m = MatComp::where('model_id',$request->input('model'))->where('line_id',$request->input('line'))->latest('id')->first();
        /* $dta = json_decode($request->input('key'),true); */
        $dta = $request->input('key');
        if($m){
            $mt = $m->materials;
            foreach ($mt as $key => $value) {
                if(
                    strtoupper($value['machine']) == strtoupper($dta['machine']) && 
                    $value['position'] == $dta['position'] && 
                    $value['feeder'] == $dta['feeder']
                    )
                {
                    /* return [
                        'type' => 'success',
                        'message' =>  $dta['machine']
                    ]; */
                    unset($mt[$key]);
                }
                /* else{
                    return [
                        'type' => 'error',
                        'message' =>  'No materials found.'
                    ];
                } */
            }
            $m->materials = $mt;
            $m->save();
            return [
                'type' => 'success',
                'message' => 'Successfully deleted' 
            ];
        }
        else{
            return [
                'type' => 'error',
                'message' => 'Error retrieving materials list.' 
            ];
        }
        
        /* return [
            'type' => 'error',
            'message' => $request->input('line').'-'.$request->input('model').'-'.$request->input('key') 
        ]; */
    }
}
