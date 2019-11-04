<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WoSnHistory;
use App\Models\NotificationEmail;
use App\Notifications\PcbDataExport;
use Carbon\Carbon;
use Notification;

class PcbExportChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exporting PCB Checker';

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
        $last = WoSnHistory::/* where('ID',666432)-> */orderBy('id','DESC')->pluck('UPLOAD_DATETIME')->first();
        $lapsed =  Carbon::now()->diffinMinutes(Carbon::parse($last));
        $msg = '';
        $err = 0;
        $emails = NotificationEmail::all();
        if($lapsed >= 60 && $lapsed < 90){
            $msg = 'The last PCB data upload was '. $lapsed .' mins ago.';
            $err = 1;
        }
        elseif($lapsed >= 90){
            $msg = 'The last PCB data upload was '. floor($lapsed/60) .' hr/s and '. floor($lapsed%60) .' min/s ago!!';
            $err = 1;
        }
        else{
            $msg = 'Good. '.$lapsed.' min/s passed.';
        }
        if($err){
            /* Notification::route('mail','edmund.mati@primatechphils.com')->notify( (new PcbDataExport($msg)) ); */
            foreach ($emails as $email) {
                $email->notify( (new PcbDataExport($msg,$email->name)) );
                sleep(5);
            }
        }        
    }
}
