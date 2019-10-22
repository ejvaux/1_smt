<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Pcb;
use App\Models\PcbArchive;

class PcbArchiving extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pcb:archive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PCB table archiving';

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
        try {
            $pcbs = Pcb::get();
            foreach ($pcbs as $pcb) {
                $id = $pcb->id;
                $ins = $pcb->toArray();
                PcbArchive::insert($ins);
                Pcb::where('id',$id)->delete();
            }            
        } catch (\Throwable $th) {
            Log::channel('single')->error("[PCB ARCHIVING] ".$th);
        }
    }
}
