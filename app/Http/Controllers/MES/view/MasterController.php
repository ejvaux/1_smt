<?php

namespace App\Http\Controllers\MES\view;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MES\model\ModName;
use App\Http\Controllers\MES\model\MachineType;
use App\Http\Controllers\MES\model\Feeder;
use App\Http\Controllers\MES\model\Mounter;
use App\Http\Controllers\MES\model\Position;
use App\Http\Controllers\MES\model\Preference;
use App\Http\Controllers\MES\model\Component;

class MasterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->machinetypes = MachineType::all();
        $this->mounters = Mounter::all();
        $this->positions = Position::all();
        $this->prefs = Preference::all();
        $this->components = Component::all();
    }
    public function index($id)
    {
        session(['user_num' => $id]);
        return redirect('fl');
    }
    public function feederlist()
    {
        $models = ModName::sortable()->orderby('updated_at','DESC')->paginate('10');
        return view('mes.pages.fl',compact('username','models'));
    }
    public function modelparts()
    {
        /* $machine_types = machineType::orderby('id')->get();
        $tables = tableSMT::orderby('id')->get(); */
        $username = '';
        return view('mes.pages.mp',compact('username'));
    }
    public function linemach()
    {
        /* $machine_types = machineType::orderby('id')->get();
        $tables = tableSMT::orderby('id')->get(); */
        $username = '';
        return view('mes.pages.lm',compact('username'));
    }
    public function employee()
    {
        /* $machine_types = machineType::orderby('id')->get();
        $tables = tableSMT::orderby('id')->get(); */
        $username = '';
        return view('mes.pages.el',compact('username'));
    }
    public function createfeederlisthome()
    {
        return view('mes.pages.cflh');
    }
    public function createfeederlistnew()
    {
        $machinetypes = $this->machinetypes;
        return view('mes.pages.cfln',compact('machinetypes'));
    }
    public function createfeederlistversion()
    {
        $machinetypes = $this->machinetypes;
        return view('mes.pages.cflv',compact('machinetypes'));
    }
    public function feederlistdetails($id)
    {
        $tb = 0;
        $mt = 0;
        $ps = 0;
        $chk = 0;
        $machinetypes = $this->machinetypes;
        $machid = Feeder::where('model_id',$id)->groupBy('machine_type_id')->pluck('machine_type_id')->first();
        $model = ModName::where('id',$id)->first();
        $mounters = $this->mounters;
        $positions = $this->positions;
        $prefs = $this->prefs;
        $components = $this->components;
        
        return view('mes.pages.fld',compact(
            'model',
            'mt',
            'ps',
            'tb',
            'mounters',
            'positions',
            'prefs',
            'components',
            'machid',
            'machinetypes',
            'chk'
        ));
    }
    public function getmachtables($mach,$id)
    {   
        $tb = 0;
        $mt = 0;
        $ps = 0;
        $machid = $id;
        $model = ModName::where('id',$mach)->first();
        /* $mounters = Mounter::all(); */
        return view('mes.inc.table.mach',compact(
            'model',
            'mt',
            'ps',
            'tb',
            'machid'
        ));
        /* if($id == 1){
            return view('mes.inc.table.cm602',compact('model','mt','ps','tb'));  
        }
        elseif ($id == 2) {
            return view('mes.inc.table.cm402',compact('model','mt','ps','tb'));
        }
        elseif ($id == 3) {
            return view('mes.inc.table.dt401',compact('model','mt','ps','tb'));
        }
        elseif ($id == 4) {
            return view('mes.inc.table.cm212',compact('model','mt','ps','tb'));
        }
        elseif ($id == 5) {
            return view('mes.inc.table.sm320',compact('model','mt','ps','tb'));
        } */
        /* return view('mes.pages.cflv'); */
    }
}