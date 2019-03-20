<?php

namespace App\Exports;

use App\scanrecordlist;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ScanRecordExport implements FromQuery, WithHeadings, WithMapping
{

    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    /* public function collection()
    {

        $itemTypes = [1, 2, 3, 4, 5];

ItemTable::whereIn('item_type_id', $itemTypes)
    ->update([
        'colour' => 'black',
        'size' => 'XL', 
        'price' => 10000 // Add as many as you need
    ]);

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
    public function __construct($date='',$pline_sel='',$process_sel='',$machine_sel='',$serial_num='')
    {
        $this->date = $date;
        $this->pline_sel = $pline_sel;
        $this->process_sel = $process_sel;
        $this->machine_sel = $machine_sel;
        $this->serial_num = $serial_num;

       
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
        $date =  $this->date;
        $pline_sel =  $this->pline_sel;
        $process_sel =  $this->process_sel;
        $machine_sel =  $this->machine_sel;
        $serial_num =  $this->serial_num;

        scanrecordlist::where('prodline_id', $pline_sel)
                ->where('process_id', $process_sel)
                ->where('updated_at', 'LIKE',$date.'%')
                ->orwhere('created_at','LIKE',$date.'%')
                ->update([
                    'ExportStatus' => '1',
                    'ExportTime' => now()
                ]);

        $query=scanrecordlist::with('userlink','errorlink','prodlinelink','processlink','machinelink')
                            ->where('prodline_id', $pline_sel)
                            ->where('process_id', $process_sel)
                            ->where('updated_at', 'LIKE',$date.'%')
                            ->orwhere('created_at','LIKE',$date.'%');
        return $query;
    }
}
