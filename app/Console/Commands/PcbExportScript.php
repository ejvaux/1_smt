<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Exports\PcbExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Division;
use App\Models\Pcb;
use App\Models\WorkOrder;
use App\Models\WoSn;

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
        /* $pcbs = Pcb::where('exported',0)->where('division_id',2)->where('type',1)->get();
        foreach ($pcbs as $pcb) {
            $wo = WorkOrder::where('ID',$pcb->jo_id)->pluck('SALES_ORDER')->first();
            if($wo != ''){
                $temp = $pcb;
                break;
            }
        } */
        $pcb = Pcb::where('exported',0)->where('division_id',2)->where('type',1)->where('defect',0)->first();
        $wo = $pcb->work_order;
        $temp = $pcb;
        if($wo != ''){
            Pcb::where('work_order',$temp->work_order)->where('exported',0)->where('division_id',2)->where('type',1)->update(['exported'=> 2]);
            $pcbvs = Pcb::where('exported',2);
            foreach ($pcbvs as $pcbv) {
                $wosn = WoSn::where('SERIAL_NUMBER',$pcbv->serial_number)->first();
                if($wosn){
                    if($pcbv->work_order != $wosn->WORK_ORDER){
                        Pcb::where('id',$pcbv->id)->update(['exported'=> 3]);
                    }
                }
                else{
                    Pcb::where('id',$pcbv->id)->update(['exported'=> 4]);
                }                
            }
            $pcbx = Pcb::where('exported',2);            
            $qty = $pcbx->count();
            $filename .= Division::where('DIVISION_ID',$temp->division_id)->pluck('DIVISION_NAME')->first() . '_';
            $filename .= $wo.'_';
            $filename .= Date('YmdHi').'_';
            $filename .= $qty;
            Excel::store(new PcbExport($temp->work_order), $filename.'.xlsx','export_smt');            
            $pcbx->update(['exported'=> 1]);
        }
        else{
            $wo = WorkOrder::where('ID',$pcb->jo_id)->pluck('SALES_ORDER')->first();
            Pcb::where('id',$pcb->id)->update(['work_order'=> $wo]);
        }
    }
}
