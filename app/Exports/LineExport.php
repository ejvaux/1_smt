<?php

namespace App\Exports;

use App\Models\WorkOrder;
use App\Models\Pcb;
use App\Custom\CustomFunctions;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Carbon\Carbon;

class LineExport implements FromQuery, WithHeadings, WithMapping, WithStrictNullComparison, WithTitle
{
    use Exportable;    

    public function __construct($line_id,$type,$fromdate,$todate,$fromtime,$totime)
    {
        $this->line_id = $line_id;
        $this->type = $type;
        $this->fromdate = $fromdate;
        $this->todate = $todate;
        $this->fromtime = $fromtime;
        $this->totime = $totime;
    }

    public function headings(): array
    {
        return [
            'SN',
            'JOB ORDER',
            'WORK ORDER',
            'PART NAME',
            'DIVISION',
            'LINE',
            'SHIFT',
            'PROCESS',
            'TYPE',
            'EMPLOYEE',
            'CREATED AT'
        ];
    }

    /**
    * @var Invoice $invoice
    */
    public function map($query): array
    {
        if($query->shift == 1){
            $type = 'OUT';
        }
        else{
            $type = 'IN';
        }
        if ($query->shift == 1){
            $shift = 'DAY';
        }            
        else{
            $shift = 'NIGHT';
        }
        $model = WorkOrder::where('ID', $query->jo_id)->pluck('ITEM_NAME')->first();
        if (strpos($model, ',') !== false) {
            $m = explode(",", $model);
            if($m[1] == 'Secure'){
                $mod = 'Main Board';
            }
            else{
                $mod = $m[1];
            }            
        }
        else{
            $mod = $model;
        }

        return [
            $query->serial_number,
            $query->jo_number,
            $query->work_order,
            $mod,
            $query->division->DIVISION_NAME,
            $query->PDLINE_NAME,
            $shift,
            $query->divprocess->name,
            $type,
            $query->employee->lname . ', ' . $query->employee->fname,
            $query->created_at
        ];
    }

    public function query()
    {
        if($this->fromtime != '' && $this->totime != ''){
            $query = Pcb::where('created_at','>=',$this->fromdate.' '.$this->fromtime)
                            ->where('created_at','<=',$this->todate.' '.$this->totime);
        }
        else{
            $query =  Pcb::where('created_at','>=',$this->fromdate.' 06:00:00')
                            ->where('created_at','<=',Carbon::parse($this->todate.' 18:00:00')->addDay());
        }
                
        $query->where('line_id',$this->line_id);
        if($this->type){
            $query->where('type',$this->type);
        }
                
        return $query->orderBy('id','DESC');
    }

    public function title(): string
    {
        return 'Sheet1';
    }
}
