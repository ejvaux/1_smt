<?php

namespace App\Exports;

use App\Models\MatSnComp;
use App\Http\Controllers\MES\model\Component;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;

class PnRidExport implements FromQuery, WithHeadings, WithMapping, WithStrictNullComparison, WithTitle
{
    use Exportable;

    public function __construct($pn)
    {
        $this->pn = $pn;
    }

    public function headings(): array
    {
        return [
            'P/N',
            'LINE',
            'RID'
        ];
    }

    /**
    * @var Invoice $invoice
    */
    public function map($query): array
    {        
        return [
            $query->component->product_number,
            $query->line->description,
            $query->RID           
        ];
    }   

    public function query()
    {
        $comp_id = Component::where('product_number',$this->pn)->pluck('id')->first();
        /* $query = MatSnComp::where('component_id',$comp_id)->groupBy('RID'); */
        $archive = MatSnCompsArchive::where('component_id',$comp_id);
        $query = MatSnComp::where('component_id',$comp_id)
                        ->union($archive)
                        ->groupBy('RID');       
        return $query;
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
