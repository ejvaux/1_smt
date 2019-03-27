<?php

namespace App\Exports;

use App\ErrorMatLoading;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ErrorExport implements FromQuery, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
   /*  public function collection()
    {
        return ErrorMatLoading::all();
    } */
    use Exportable;
    public function headings(): array
    {
        return [
            'DATE',
            'COMPONENT PN',
            'VENDOR',
            'MACHINE',
            'MODEL',
            'TABLE',
            'MOUNTER',
            'POSITION',
            'EMPLOYEE',
            'ERROR INFO'
          
        ];
    }
    public function __construct($date='')
    {
        $this->date = $date;
       
    }
    public function map($query): array
    {
        if($query->smt_table_rel->name=="A"){
            $table = "TABLE 1";
        }
        else if($query->smt_table_rel->name=="B"){
            $table = "TABLE 2";
        }
        else if($query->smt_table_rel->name=="C"){
            $table = "TABLE 3";
        }
        else if($query->smt_table_rel->name=="D"){
            $table = "TABLE 4";
        }
        return [
            $query->created_at,
            $query->component_rel->product_number,
            $query->component_rel->authorized_vendor,
            $query->machine_rel->code,
            $query->smt_model_rel->code,
            $table,
            $query->mounter_rel->code,
            $query->smt_pos_rel->name,
            $query->employee_rel->lname.", ".$query->employee_rel->fname,
            $query->ErrorType
        ];
    }
    public function query()
    {

        $date =  $this->date;
        $query=ErrorMatLoading::with('machine_rel','smt_model_rel','smt_table_rel','mounter_rel','smt_pos_rel','component_rel','order_rel','employee_rel')
                            ->where('created_at', 'LIKE',$date.'%')
                            ->orderby('created_at','DESC');        
        return $query;
    }
}
