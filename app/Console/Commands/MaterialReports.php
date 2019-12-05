<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\MaterialReport;
use App\MatLoadModel;
use App\Jobs\InsertMatRep;

class MaterialReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'material:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processing of SMT Material Reports';

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
        $today = Date('Y-m-d');
        /* $today = Date('2019-12-03'); */
        $dt = Carbon::parse($today)->subday();
        $from = Carbon::parse($today)->subday()->addHours(6);
        $to = Carbon::parse($today)->addHours(6);
        $mat_loads = MatLoadModel::where('created_at','>=',$from)
                                ->where('created_at','<',$to)
                                /* ->take(5) */
                                ->get();
        /* $mat_loads = MatLoadModel::where('id',62229)->first(); */
        foreach ($mat_loads as $mat_load) {
            InsertMatRep::dispatch($mat_load,$dt);
        }        
    }
}
