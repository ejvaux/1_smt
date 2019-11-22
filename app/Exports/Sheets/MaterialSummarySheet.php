<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use \Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

use Carbon\Carbon;
use App\Models\MaterialReport;

class MaterialSummarySheet implements FromArray, WithStrictNullComparison, WithTitle, WithEvents, WithColumnFormatting
{
    private $date;

    public function __construct($date)
    {
        $this->date = $date;
    }

    public function registerEvents(): array
    {
        Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        });
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->styleCells(
                    'A1:P1',
                    [
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                            'rotation' => 90,
                            'startColor' => [
                                'argb' => 'FFE699',
                            ],
                            'endColor' => [
                                'argb' => 'FFE699',
                            ],
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ],
                        ]
                    ]
                );
                $event->sheet->styleCells(
                    'A2:A7',
                    [
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                            'rotation' => 90,
                            'startColor' => [
                                'argb' => 'FFE699',
                            ],
                            'endColor' => [
                                'argb' => 'FFE699',
                            ],
                        ],
                    ]
                );
                $event->sheet->styleCells(
                    'A1:P7',
                    [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ],
                        ]
                    ]
                );
            },
        ];
    }

    public function array(): array
    {
        function getresults($line,$date)
        {
            $q = MaterialReport::where('date',$date)->where('line',$line);
            $targetTotal = $q->sum('target_qty');
            $systemTotal = $q->sum('sys_qty');
            if($targetTotal){
                $result = $systemTotal/$targetTotal;
            }
            else{
                $result = 0;
            }
            return $result;
        }

        $array = [];
        $header = [];
        $table = [];
        $c = 1;
        $dt = Carbon::parse($this->date)->subdays(14);

        $header[] = 'LINE';
        $tables = [
            ['SMTL1'],
            ['SMTL2'],
            ['SMTL3'],
            ['SMTL6'],
            ['SMTL12'],
            ['SMTL13']
        ];
        $dates = MaterialReport::wherebetween('date',[$dt,$this->date])->groupBy('date')->pluck('date');
        foreach ($dates as $date) {
            $header[] = Date('m/d',strtotime($date));

            for ($i=0; $i < 6; $i++) {
                $tables[$i][$c] = getresults($tables[$i][0],$date);
            }

            /* $tables[0][$c] = getresults($tables[0][0],$date);
            $tables[1][$c] = getresults($tables[0][0],$date);
            $tables[2][$c] = getresults($tables[0][0],$date);
            $tables[3][$c] = getresults($tables[0][0],$date);
            $tables[4][$c] = getresults($tables[0][0],$date);
            $tables[5][$c] = getresults($tables[0][0],$date); */

            $c++;
        }

        $array[] = $header;
        $array[] = $tables;
        return $array;
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_PERCENTAGE,
            'C' => NumberFormat::FORMAT_PERCENTAGE,
            'D' => NumberFormat::FORMAT_PERCENTAGE,
            'E' => NumberFormat::FORMAT_PERCENTAGE,
            'F' => NumberFormat::FORMAT_PERCENTAGE,
            'G' => NumberFormat::FORMAT_PERCENTAGE,
            'H' => NumberFormat::FORMAT_PERCENTAGE,
            'I' => NumberFormat::FORMAT_PERCENTAGE,
            'J' => NumberFormat::FORMAT_PERCENTAGE,
            'K' => NumberFormat::FORMAT_PERCENTAGE,
            'L' => NumberFormat::FORMAT_PERCENTAGE,
            'M' => NumberFormat::FORMAT_PERCENTAGE,
            'N' => NumberFormat::FORMAT_PERCENTAGE,
            'O' => NumberFormat::FORMAT_PERCENTAGE,
            'P' => NumberFormat::FORMAT_PERCENTAGE,
        ];
    }

    public function title(): string
    {
        return 'Summary';
    }
}