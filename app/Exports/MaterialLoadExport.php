<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use App\MatLoadModel;

class MaterialLoadExport implements FromQuery, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

/*     public function collection()
    {
        return MatLoadModel::all();
    } */
    public function headings(): array
    {
        return [
            'DATE',
            'COMPONENT PN',
            'VENDOR',
            'MODEL',
            'LINE',
            'MACHINE',            
            'TABLE',
            'MOUNTER',
            'POSITION',
            'EMPLOYEE'
          
        ];
    }
    public function __construct($date='')
    {
        $this->date = $date;
       
    }
    public function map($query): array
    {
        /* if($query->smt_table_rel->name=="A"){
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
        } */
        $table = 'Table ' . $query->table_id;
        return [
            $query->created_at,
            $query->component_rel->product_number,
            $query->component_rel->authorized_vendor,
            $query->smt_model_rel->code,
            $query->machine_rel->line2->description,
            $query->machine_rel->machine_type_rel->name,
            $table,
            $query->mounter_rel->code,
            $query->smt_pos_rel->name,
            $query->employee_rel->lname.", ".$query->employee_rel->fname
           
        ];
    }
    public function query()
    {

        $date =  $this->date;
        $query=MatLoadModel::with('machine_rel','smt_model_rel','smt_table_rel','mounter_rel','smt_pos_rel','component_rel','order_rel','employee_rel')
                            ->where('created_at', 'LIKE',$date.'%')
                            ->orderby('created_at','DESC');        
        return $query;
    }

}
