<?php

namespace App\Exports;

use App\Models\DefectMat;
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

class DefectMatsExport implements FromQuery, WithHeadings, WithMapping, WithStrictNullComparison, WithTitle
{
    use Exportable;    

    public function __construct($from,$to,$item)
    {
        $this->from = $from;
        $this->to = $to;
        $this->item = $item;
    }

    public function headings(): array
    {
        return [
            'STATUS',
            'LEAD TIME',
            'MODEL',
            'DIVISION',
            'LINE',
            'SHIFT',
            'PROCESS',
            'S/N',
            'DEFECT',
            'DEFECT TYPE',
            'INSERTED BY',
            'DEFECTED AT',
            'REPAIRED BY',
            'REPAIRED AT',
            'REMARKS'
        ];
    }

    /**
    * @var Invoice $invoice
    */
    public function map($query): array
    {
        $rname = '';
        $ltime = '';
        if($query->repair == 1){
            $stat = 'REPAIRED';
            $rname = $query->repairby->lname . ', ' . $query->repairby->fname;
        }
        else{
            $stat = 'NG';
        }
        if ($query->repair){
            $ltime = CustomFunctions::datefinished($query->created_at,$query->repaired_at);
        }

        if ($query->shift == 1){
            $shift = 'DAY';
        }            
        else{
            $shift = 'NIGHT';
        }
        $joid = Pcb::where('id',$query->pcb_id)->pluck('jo_id')->first();
        $model = WorkOrder::where('ID', $joid)->pluck('ITEM_NAME')->first();
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
            $stat,
            $ltime,
            $mod,
            $query->defect->division->DIVISION_NAME,
            $query->line->name,
            $shift,
            $query->process->name,
            $query->pcb->serial_number,
            $query->defect->DEFECT_NAME,
            $query->defectType->name,
            $query->employee->lname . ', ' . $query->employee->fname,
            $query->created_at,
            $rname,
            $query->repaired_at,
            $query->remarks
        ];
    }

    public function query()
    {
        if($this->item == 1){
            $query = DefectMat::whereDate('created_at','>=',$this->from)->whereDate('created_at','<=',$this->to);
        }
        else{
            $query = DefectMat::whereDate('repaired_at','>=',$this->from)->whereDate('repaired_at','<=',$this->to);
        }        
        return $query->orderBy('created_at');
    }

    public function title(): string
    {
        return 'Sheet1';
    }
}
