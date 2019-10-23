<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Pcb;
use App\Models\PcbArchive;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        for ($i=0; $i < 280; $i++) { 
            try {
                $pcbs = Pcb::where('created_at','<=',Carbon::parse(Date('Y-m-d'))->subMonth())->limit(4)->get();
                foreach ($pcbs as $pcb) {
                    $id = $pcb->id;
                    $ins = $pcb->toArray();
                    /* DB::transaction(function () use($ins) {
                        PcbArchive::insert($ins);
                    });
                    DB::transaction(function () use($id) {
                        Pcb::where('id',$id)->delete();
                    }); */
                    /* PcbArchive::insert($ins);
                    Pcb::where('id',$id)->delete(); */
                    DB::transaction(function () use($ins,$id) {
                        PcbArchive::insert($ins);
                        Pcb::where('id',$id)->delete();
                    });
                }            
            } catch (\Throwable $th) {
                Log::channel('single')->error("[PCB ARCHIVING] ".$th);
            }
            sleep(1);
        }        
    }
}
