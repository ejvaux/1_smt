<?php

namespace App\Http\Controllers\feeder\view;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\machineType;
use App\tableSMT;

class FeederListController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $machine_types = machineType::orderby('id')->get();
        $tables = tableSMT::orderby('id')->get();
        return view('pages.feeder.fl',compact('machine_types','tables'));
    }
}
