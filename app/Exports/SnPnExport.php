<?php

namespace App\Exports;

use App\Models\MatSnComp;
use App\Models\MatSnCompsArchive;
use App\Models\Pcb;
use App\Models\PcbArchive;
use App\Http\Controllers\MES\model\Component;
use App\Http\Controllers\MES\model\LineName;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromArray;

class SnPnExport implements WithHeadings, WithStrictNullComparison, WithTitle, FromArray
{
    use Exportable;

    public function __construct($sn,$cid)
    {
        $this->sn = $sn;
        $this->cid = $cid;
    }

    public function headings(): array
    {
        return [
            'S/N',
            'BOTTOM OUT',
            'TOP OUT',
            'PN',
            'RID'
        ];
    }

    public function title(): string
    {
        return 'Sheet1';
    }

    public function array(): array
    {
        $snrids = [];
        $snr = [];
        /* $sns = explode(",",$this->sn); */
        if(stripos($this->sn, ',')){
            $sns = explode(",",$this->sn);
        }
        else{
            $sns = explode(" ",$this->sn);
        }
        /* $mats = MatSnComp::where('component_id',$this->cid)->get(); */
        $archive = MatSnCompsArchive::where('component_id',$this->cid);
        $mats = MatSnComp::where('component_id',$this->cid)
                        ->union($archive)
                        ->get();
        $c = Component::where('id',$this->cid)->pluck('product_number')->first();
        /* foreach ($sns as $sn) {
            $snrids[$sn] = [
                            "RID" => '',
                            "line" => ''
                            ];
        }

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
        } */

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

        foreach ($snrids as $rid => $r) {
            $snr[] = [
                        $rid,                                    
                        $r['BOT'],
                        $r['TOP'],
                        $r['PN'],
                        $r['RID']
                        ];
        }

        /* foreach ($mats as $mat) {
            foreach($mat->sn as $m){
                foreach ($sns as $sn) {
                    if($m == $sn){
                        $snrids[] = [
                                    $sn,                                    
                                    LineName::where('id',$mat->line_id)->pluck('description')->first(),
                                    $mat->RID
                                    ];
                    }
                }                
            }
        } */
        return  $snr;
    }
}
