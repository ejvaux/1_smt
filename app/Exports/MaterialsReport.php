<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Carbon\Carbon;
use App\Exports\Sheets\MaterialSummarySheet;
use App\Exports\Sheets\MaterialRawSheet;

class MaterialsReport implements WithMultipleSheets
{
    use Exportable;

    protected $date;
    
    public function __construct($date)
    {
        $this->date = $date;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {        
        $dt = Carbon::parse($this->date)->subdays(14);
        /* $sheets = [
            0 => new MaterialSummarySheet($this->date),
            1 => new MaterialRawSheet($this->date)
        ]; */
        
        $sheets[] = new MaterialSummarySheet($this->date);
        /* $sheets[] = new MaterialRawSheet($this->date); */
        for ($i=0; $i < 3; $i++) { 
            $sheets[] = new MaterialRawSheet(Carbon::parse($this->date)->subdays($i));
        }
        return $sheets;
    }
}
