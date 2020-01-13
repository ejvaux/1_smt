<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\MatSnCompsArchive;
use App\Models\MatSnComp;

class MaterialArchive implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $mats = MatSnComp::where('created_at','<=',Carbon::parse(Date('Y-m-d'))->submonth())->limit(1)->get();
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
    }
}
