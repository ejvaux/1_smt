<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PcbExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportsController extends Controller
{
    public function index()
    {
        return view('pages.export.ep'/* ,compact() */);
    }
    public function exportpcb(Request $request)
    {
        $filename = 'PRIMA';
        /* if($request->input('division_id')){

        } */

        return
            (new PcbExport())->download('Sample_Export.xlsx');
    }
}
