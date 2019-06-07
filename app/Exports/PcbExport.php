<?php

namespace App\Exports;

use App\Models\Pcb;
use App\Models\WorkOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Carbon\Carbon;

class PcbExport implements FromQuery, WithHeadings, WithMapping, WithStrictNullComparison, WithTitle
{
    use Exportable;

    public function headings(): array
    {
        return [
            'PDLINE_NAME',
            'EMP',
            'SN',
            'RESULT',
            'ERROR_CODE',
            'PROCESS_NAME',
            'MACHINE',
            'TIME'
        ];
    }

    /**
    * @var Invoice $invoice
    */
    public function map($query): array
    {        
        return [
            $query->PDLINE_NAME,
            $query->employee_id,
            $query->serial_number,
            $query->RESULT,
            $query->ERROR_CODE,
            $query->PROCESS_NAME,
            $query->MACHINE,
            $query->created_at,            
        ];
    }

    public function __construct($joid)
    {
        $this->joid = $joid;        
    }

    public function query()
    {
        /* $query = Pcb::all();
        return $query; */
        /* $query = new Pcb();
        foreach ($this->jos as $jo) {
            $query->where('jo_id',$jo->ID);
        } */
        /* $query = new Pcb::where(); */
        return Pcb::where('jo_id',$this->joid);

        /* return Pcb::orderby('id'); */
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
        return Pcb::all();
    } */
}
