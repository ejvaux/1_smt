<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\MatSnCompsArchive;
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
        function func(){
            try {
                $mats = MatSnComp::where('created_at','<=',Carbon::parse(Date('Y-m-d'))->submonth())->limit(4)->get();
                foreach ($mats as $mat) {
                    $id = $mat->id;
                    /* $ins = $mat->toArray(); */
                    DB::transaction(function () use($id,$mat) {
                        /* MatSnCompsArchive::insert($ins); */

                        //

                            $arc = new MatSnCompsArchive;
                            $arc->id = $mat->id;
                            $arc->model_id = $mat->model_id;
                            $arc->line_id = $mat->line_id;
                            $arc->mat_comp_id = $mat->mat_comp_id;
                            $arc->component_id = $mat->component_id;
                            $arc->RID = $mat->RID;
                            $arc->sn = $mat->sn;
                            $arc->created_at = $mat->created_at;
                            $arc->updated_at = $mat->updated_at;
                            $arc->save();
                            
                        //

                        MatSnComp::where('id',$id)->delete();
                    });
                }            
            } catch (\Throwable $th) {
                Log::channel('single')->error("[MATERIAL ARCHIVING] ".$th);
            }
            sleep(1);
        }

        while (true) {
            func();
        }
    }
}
