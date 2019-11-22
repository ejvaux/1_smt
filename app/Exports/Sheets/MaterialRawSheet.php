<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use \Maatwebsite\Excel\Sheet;

use Carbon\Carbon;
use App\Models\MaterialReport;

class MaterialRawSheet implements FromQuery, WithHeadings, WithMapping, WithStrictNullComparison, WithTitle, ShouldAutoSize, WithColumnFormatting, WithEvents
{ 
    use Exportable;

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
                    'A1:K1',
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
                        'font' => [
                            'bold' => true,
                        ],
                    ]
                );
                $event->sheet->styleCells(
                    'A1:K100',
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

    public function headings(): array
    {
        return [
            'SMT Line',
            'PCBA PN',
            'Program',
            'RID No.',
            'Component PN',
            'Feeding Time',
            "Reel Component Q'TY",
            "Usage",
            "Target Q'TY",
            "Searched Q'TY",
            'Accuracy Rate'
        ];
    }

    public function map($query): array
    {
        $acc = $query->sys_qty/$query->target_qty;
        return [
            $query->line,
            $query->pcb_pn,
            $query->program,
            $query->reel_id,
            $query->component_pn,
            $query->feed_time,
            $query->reel_qty,
            $query->usage,
            $query->target_qty,
            $query->sys_qty,
            $acc,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'K' => NumberFormat::FORMAT_PERCENTAGE,
        ];
    }

    public function query()
    {
        $query = MaterialReport::where('date',$this->date);
        return $query;
    }

    public function title(): string
    {
        $dt = Carbon::parse($this->date);
        $dt = $dt->format('m-d');
        return $dt;
    }
}