<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MaterialsReport;
use Carbon\Carbon;
use App\Models\NotificationEmail;
use App\Notifications\MaterialReportEmail;
use Illuminate\Support\Facades\Storage;

class MaterialReportsExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'material:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exporting of SMT Material Reports';

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
        $dt = Carbon::parse($today)->subday(1);
        $filename = 'PRIMA MES Daily Report - '.Date('M d, Y',strtotime($dt));
        Excel::store(new MaterialsReport($dt), $filename.'.xlsx','material_report');

        $emails = NotificationEmail::where('type',1)->get();
        foreach ($emails as $email) {
            $email->notify( (new MaterialReportEmail($filename,$email)) );
        }

        // Add Delay
        sleep(20);
        
        // Moving Sent file
        Storage::disk('material_report')->move($filename.'.xlsx', 'Sent/'.$filename.'.xlsx');
    }
}
