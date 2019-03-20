<?php

namespace App\Exports;

use App\scanrecordlist;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AutoScanRecordExport implements FromQuery, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    /* public function collection()
    {
        return scanrecordlist::all();
    } */




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
    public function __construct($WorkOrder='')
    {
        $this->WorkOrder = $WorkOrder;
     
       
    }
    public function map($query): array
    {
        if($query->error_id){
            $errorCode =  $query->errorlink->error_code;
        }
        else{
            $errorCode =  "";
        }
        return [
            $query->prodlinelink->prodline_ini,
            $query->user_id,
            $query->serial_number,
            $query->scan_result,
            $errorCode,
            $query->processlink->process_ini,
            $query->machine_id,
            $query->updated_at
           
        ];
    }
    public function query()
    {
        //->where('machine_id', $machine_sel)
        $WorkOrder =  $this->WorkOrder;

      

        $query=scanrecordlist::with('userlink','errorlink','prodlinelink','processlink','machinelink')
                            ->where('SapPlanID', $WorkOrder)
                            ->where('process_id', $process_sel)
                            ->where('updated_at', 'LIKE',$date.'%')
                            ->orwhere('created_at','LIKE',$date.'%');



        scanrecordlist::where('SapPlanID', $date)
                        ->where('process_id', $process_sel)
                        ->where('updated_at', 'LIKE',$date.'%')
                        ->orwhere('created_at','LIKE',$date.'%')
                        ->update([
                            'ExportStatus' => '1',
                            'ExportTime' => now()
                        ]);               

        return $query;
    }
}
