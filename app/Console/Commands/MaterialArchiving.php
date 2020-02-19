<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\MaterialArchive;
use App\Models\MatSnComp;

class MaterialArchiving extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'material:archive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Materials table archiving';

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
        /* for ($i=0; $i < 90; $i++) { 
            MaterialArchive::dispatch();
            usleep(500000);
        } */
        
        /* while (true) {
            MaterialArchive::dispatch();
            sleep(1);
        } */

        $mats = MatSnComp::where('created_at','<=',Carbon::parse(Date('Y-m-d'))->submonth())->get();
        /* $mats = MatSnComp::whereIn('id',[3731905,3731906])->get(); */
        if($mats){
            foreach ($mats as $mat) {
                MaterialArchive::dispatch($mat);
            }
        }
    }
}
