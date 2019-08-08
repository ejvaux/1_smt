<?php

namespace App\Exports;

use App\Models\MatSnComp;
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
            'SN',
            'LINE',
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
        $sns = explode(",",$this->sn);
        $mats = MatSnComp::where('component_id',$this->cid)->get();

        foreach ($mats as $mat) {
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
        }
        return  $snrids;
    }
}
