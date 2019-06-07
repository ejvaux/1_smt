<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Exports\PcbExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Division;
use App\Models\Pcb;
use App\Models\WorkOrder;

class PcbExportScript extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:pcb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exporting PCB entries';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $filename = 'PRIMA_';
        $qty = 0;
        $pcbs = Pcb::where('exported',0)->get();
        foreach ($pcbs as $pcb) {
            $wo = WorkOrder::where('ID',$pcb->jo_id)->pluck('SALES_ORDER')->first();
            if($wo != ''){
                $temp = $pcb;
                break;
            }
        }
        if($wo != ''){
            $qty = Pcb::where('jo_id',$temp->jo_id)->count();
            $filename .= Division::where('DIVISION_ID',$temp->division_id)->pluck('DIVISION_NAME')->first() . '_';
            if($wo == ''){
                $filename .= 'NoWorkOrder_';
            }
            else{
                $filename .= $wo.'_';
            }
            $filename .= Date('YmdHi').'_';
            $filename .= $qty;
            Pcb::where('jo_id',$temp->jo_id)->update(['exported'=> 1]);            
            Excel::store(new PcbExport($temp->jo_id), $filename.'.xlsx','local');
        }
        /* if(Pcb::where('exported',0)->first()){
            $filename = 'PRIMA_';
            $qty = 0;
            $pcb = Pcb::where('exported',0)->first();
            $wo = WorkOrder::where('ID',$pcb->jo_id)->pluck('SALES_ORDER')->first();
            $qty = Pcb::where('jo_id',$pcb->jo_id)->count();
            $filename .= Division::where('DIVISION_ID',$pcb->division_id)->pluck('DIVISION_NAME')->first() . '_';
            if($wo == ''){
                $filename .= 'NoWorkOrder_';
            }
            else{
                $filename .= $wo.'_';
            }
            $filename .= Date('YmdHi').'_';
            $filename .= $qty;
            Pcb::where('jo_id',$pcb->jo_id)->update(['exported'=> 1]);            
            Excel::store(new PcbExport($pcb->jo_id), $filename.'.xlsx','export_test');
        } */
    }
}
