<?php

namespace App\Exports;

use App\Custom\CustomFunctions;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Http\Controllers\MES\model\Employee;

class EmployeeExport implements FromQuery, WithHeadings, WithMapping, WithStrictNullComparison, WithTitle
{
    use Exportable;    

    public function __construct($employees)
    {
        $this->employees = $employees;
    }
 
    public function headings(): array
    {
        return [
            'fname',
            'lname',
            'pin'
        ];
    }

    /**
    * @var Invoice $invoice
    */
    public function map($query): array
    {        

        return [
            $query->fname,
            $query->lname,
            $query->pin
        ];
    }

    public function query()
    {
        $query = Employee::whereIn('id',$this->employees);
                
        return $query->orderBy('id','DESC');
    }

    public function title(): string
    {
        return 'Sheet1';
    }
}
