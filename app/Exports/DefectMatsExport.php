<?php

namespace App\Exports;

use App\Models\DefectMat;
use App\Models\WorkOrder;
use App\Models\Pcb;
use App\Models\Location;
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

    public function __construct($from,$to,$status,$line,$shift)
    {
        $this->from = $from;
        $this->to = $to;
        $this->status = $status;
        $this->line = $line;
        $this->shift = $shift;
    }

    public function headings(): array
    {
        return [
            'STATUS',
            'LEAD TIME',
            'PART NAME',
            'DIVISION',
            'LINE',
            'SHIFT',
            'PROCESS',
            'S/N',
            'DEFECT',
            'LOCATION',
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
            $stat = 'GOOD';
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
        $locs = '';
        if(isset($query->d_locations)){
            $locid = '';            
            foreach ($query->d_locations as $key => $value) {
                if(isset($value['location_id'])){
                    $locid = $value['location_id']; 
                }
                else{
                    $locid = $value;
                }
                $locs .= Location::where('id',$locid)->first()->name;
                if($key != count($query->d_locations) - 1){
                    $locs .= ', ';
                }
            }
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
            $locs,
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
        $dte = $this->from;
        $dte2 = Carbon::parse($this->to.' 06:00:00')->addDay();
        $query = DefectMat::where('created_at','>=',$dte.' 06:00:00')
                            ->where('created_at','<',$dte2);
        if($this->shift != ''){
            if($this->shift == 1){
                $query->where('shift',1);
            }
            else if($this->shift == 2){
                $query->where('shift',2);
            }
        }
        if($this->status != ''){
            if($this->status == 1){
                $query->where('repair',0);
            }
            else if($this->status == 2){
                $query->where('repair',1);
            }
        }
        if($this->line != ''){
            $query->where('line_id',$this->line);
        }        
                
        return $query->orderBy('id','DESC');
    }

    public function title(): string
    {
        return 'Sheet1';
    }
}
