<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProdLine;
use App\ProcessList;
use App\errorcodelist;
class PageController extends Controller
{
    //
    public function scan(){

        $pline=ProdLine::all();
        $processlist=ProcessList::all();
        $ecode=errorcodelist::all();
        $data="";
        
        return view('pages.scan.scanpage',compact('pline','processlist','ecode','data'));
    }
}
