<?php

namespace App\Http\Controllers\MES\view;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MES\model\ModName;
use App\Http\Controllers\MES\model\Machine;
use App\Http\Controllers\MES\model\MachineType;
use App\Http\Controllers\MES\model\Feeder;
use App\Http\Controllers\MES\model\Mounter;
use App\Http\Controllers\MES\model\Position;
use App\Http\Controllers\MES\model\Preference;
use App\Http\Controllers\MES\model\Component;
use App\Http\Controllers\MES\model\Line;

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
        $this->machines = Machine::all();
    }
    public function index()
    {
        return redirect('fl');
    }
    public function feederlist(Request $request)
    {
        $t = $request->input('text');        
        if($t == ''){
            $models = ModName::sortable()->orderby('updated_at','DESC')->paginate('10');
        }
        else{
            $models = ModName::sortable()
                ->where('code','LIKE','%'.$t.'%')
                ->orwhere('program_name','LIKE','%'.$t.'%')
                ->orwhere('updated_by','LIKE','%'.$t.'%')
                ->orwhere('updated_at','LIKE','%'.$t.'%')
            ->orderby('updated_at','DESC')->paginate('10');
        }        
        return view('mes.pages.fl',compact('models'));
    }
    public function components(Request $request)
    {
        $t = $request->input('text');
        if($t == ''){
            $components = Component::sortable()->orderby('id','DESC')->paginate('100');
        }
        else{            
            $components = Component::sortable()
                ->where('product_number','LIKE','%'.$t.'%')
                ->orwhere('authorized_vendor','LIKE','%'.$t.'%')
                ->orwhere('vendor_pn','LIKE','%'.$t.'%')
            ->orderby('id','DESC')->paginate('100');
        }        
        $username = '';
        return view('mes.pages.cl',compact('username','components'));
    }
    public function linestruc(Request $request)
    {
        $t = $request->input('text');
        $machines = $this->machines;
        if($t == ''){
            $lines = Line::sortable()->orderBy('id','DESC')->paginate('10');
        }
        else{            
            $lines = Line::sortable()
                ->where('code','LIKE','%'.$t.'%')
            ->orderBy('id','DESC')->paginate('10');
        } 
        return view('mes.pages.ls',compact('lines','machines'));
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
    public function feederlistdetails($id,$mid)
    {
        $tb = 0;
        $mt = 0;
        $ps = 0;
        $chk = 0;
        $machinetypes = $this->machinetypes;
        if ($mid == 0) {
            $machid = Feeder::where('model_id',$id)->groupBy('machine_type_id')->pluck('machine_type_id')->first();
        }
        else{
            $machid = $mid;
        }     
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
        $mounters = $this->mounters;
        $model = ModName::where('id',$mach)->first();
        /* $mounters = Mounter::all(); */
        return view('mes.inc.table.mach',compact(
            'model',
            'mt',
            'ps',
            'tb',
            'mounters',
            'machid'
        ));
    }

    /* SEARCHING */
    public function searchmodel(Request $request)
    {   
        $t = $request->input('text');
        $models = ModName::sortable()
                ->where('code','LIKE','%'.$t.'%')
                ->orwhere('program_name','LIKE','%'.$t.'%')
                ->orwhere('updated_by','LIKE','%'.$t.'%')
                ->orwhere('updated_at','LIKE','%'.$t.'%')
        ->orderby('updated_at','DESC')->paginate('10');
        return view('mes.pages.fl',compact('models'));        
    }
}