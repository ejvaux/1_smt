<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pcb;

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

        return [
            'sn' => $sn,
            'bi' => $bi,
            'bo' => $bo,
            'ti' => $ti,
            'to' => $to
        ];

    }
}
