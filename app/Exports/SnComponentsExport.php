<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Pcb;
use App\Models\PcbArchive;
use App\Models\MatComp;
use App\Exports\PcbExport;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class SnComponentsExport implements FromView, WithTitle
{
    public function __construct($sn)
    {
        $this->sn = $sn;
    }

    public function view(): View
    {
        $reels = array();
        $mid = array();
        $bot = Pcb::where('serial_number',$this->sn)->where('type',0)->where('div_process_id',1)->orderBy('id','DESC')->first();
        $top = Pcb::where('serial_number',$this->sn)->where('type',0)->where('div_process_id',2)->orderBy('id','DESC')->first();
        if(!$bot){
            $bot = PcbArchive::where('serial_number',$this->sn)->where('type',0)->where('div_process_id',1)->orderBy('id','DESC')->first();
        }
        if(!$top){
            $top = PcbArchive::where('serial_number',$this->sn)->where('type',0)->where('div_process_id',2)->orderBy('id','DESC')->first();
        }
        if($bot){
            array_push($mid, $bot->mat_comp_id);
            $sn = $this->sn;
        }
        if($top){
            array_push($mid, $top->mat_comp_id);
            $sn = $this->sn;
        }        
        $rs = MatComp::whereIn('id',$mid)->get();
        foreach ($rs as $r) {
            array_push($reels, $r->materials);
        }

        return view('includes.table.sntTable', [
            'reels' => $reels,
            'sn' => $sn
        ]);
    }

    public function title(): string
    {
        return 'Sheet1';
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    /* public function collection()
    {
        //
    } */
}
