<?php

namespace App\Exports;

use App\Models\MatSnComp;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class ReelSnExport implements FromView, WithTitle
{
    public function __construct($rid)
    {
        $this->rid = $rid;
    }

    /* public function headings(): array
    {
        return [
            'SN'
        ];
    }   

    public function array(): array
    {
        $sns = [];
        $serials = MatSnComp::where('RID',$this->rid)->get();
        foreach ($serials as $serial){
            foreach($serial->sn as $s){
                $sns[] = [$s];
            }
        }
        return $sns;
    } */

    public function view(): View
    {
        $serials = MatSnComp::select('mat_comp_id','component_id','sn')->where('RID',$this->rid)->get();
        $reel = $this->rid;
        return view('includes.table.reelTableExport', compact('serials','reel'));
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
