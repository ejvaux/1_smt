<?php

namespace App\Exports;

use App\Models\MatSnComp;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromArray;

class ReelSnExport implements WithHeadings, WithStrictNullComparison, WithTitle, FromArray
{
    use Exportable;

    public function __construct($rid)
    {
        $this->rid = $rid;
    }

    public function headings(): array
    {
        return [
            'SN'
        ];
    }

    public function title(): string
    {
        return 'Sheet1';
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
        /* return [
            [1, 2, 3],
            [4, 5, 6]
        ]; */
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    /* public function collection()
    {
        //
    } */
}
