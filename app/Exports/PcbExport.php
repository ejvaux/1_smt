<?php

namespace App\Exports;

use App\Models\Pcb;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Carbon\Carbon;

class PcbExport implements FromQuery, WithHeadings, WithMapping, WithStrictNullComparison
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

    public function __construct()
    {
        /* $this->user_id = $user_id;  */       
    }

    public function query()
    {
        /* $query = Pcb::all();
        return $query; */
        return Pcb::orderby('id');
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    /* public function collection()
    {
        return Pcb::all();
    } */
}
