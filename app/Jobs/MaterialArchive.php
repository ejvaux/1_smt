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
    
    protected $mat;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mat)
    {
        $this->mat = $mat;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $id = $this->mat->id;
        
        // Insert to archive table
        $arc = new MatSnCompsArchive;
        $arc->id = $this->mat->id;
        $arc->model_id = $this->mat->model_id;
        $arc->line_id = $this->mat->line_id;
        $arc->mat_comp_id = $this->mat->mat_comp_id;
        $arc->component_id = $this->mat->component_id;
        $arc->RID = $this->mat->RID;
        $arc->sn = $this->mat->sn;
        $arc->created_at = $this->mat->created_at;
        $arc->updated_at = $this->mat->updated_at;
        $arc->save();

        // Delete from main table
        try {
            MatSnComp::where('id',$id)->delete();
        } catch (\Throwable $th) {}        

        /* try {
                        
        } catch (\Throwable $th) {
            Log::channel('single')->error("[MATERIAL ARCHIVING] ".$th);
        } */

        /* $mats = MatSnComp::where('created_at','<=',Carbon::parse(Date('Y-m-d'))->submonth())->limit(1)->get();        if($mats){
            foreach ($mats as $mat) {
                $id = $mat->id;
                // $ins = $mat->toArray();
                DB::transaction(function () use($id,$mat) {
                    // MatSnCompsArchive::insert($ins);

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
        } */
        
    }
}
