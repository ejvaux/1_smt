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
use App\Http\Controllers\MES\model\LineName;
use App\Http\Controllers\MES\model\Employee;
use App\Http\Controllers\MES\model\Process;
use App\Models\Division;

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
        $this->linenames = LineName::orderBy('division_id')->get();
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
        $machines = Machine::where('line_id',0)->get();
        $machines1 = Machine::where('line_id','!=',0)->orderBy('machine_type_id')->get();
        $linenames = $this->linenames;
        if($t == ''){
            $lines = Line::sortable()->orderBy('line_name_id','DESC')->paginate('10');
        }
        else{            
            $lines = Line::sortable()
                ->where('code','LIKE','%'.$t.'%')
            ->orderBy('line_name_id','DESC')->paginate('10');
        } 
        return view('mes.pages.ls',compact('lines','machines','machines1','linenames'));
    }
    public function employee(Request $request)
    {
        $t = $request->input('text');
        $empps = Employee::all();
        if($t == ''){
            $employees = Employee::sortable()->orderBy('id','DESC')->paginate('20');
        }
        else{
            $employees = Employee::sortable()
                ->where('fname','LIKE','%'.$t.'%')
                ->orwhere('lname','LIKE','%'.$t.'%')
            ->orderBy('id')->paginate('20');
        }       
        return view('mes.pages.el',compact('employees','empps'));
    }
    public function machine(Request $request)
    {
        $t = $request->input('text');
        $machinetypes = $this->machinetypes;
        if($t == ''){
            $machines = Machine::sortable()->orderBy('machine_type_id')->paginate('20');
        } else{
            $machines = Machine::sortable()
                ->where('code','LIKE','%'.$t.'%')
            ->orderBy('machine_type_id')->paginate('20');
        }
        return view('mes.pages.ml',compact('machines','machinetypes'));
    }
    public function line(Request $request)
    {
        $t = $request->input('text');
        if($t == ''){
            $linenames = LineName::sortable()->orderBy('id')->paginate('20');
        } else{
            $linenames = LineName::sortable()
                ->where('name','LIKE','%'.$t.'%')
            ->orderBy('id')->paginate('20');
        }
        return view('mes.pages.ln',compact('linenames'));
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
    public function feederlistdetails($id,$mid,$linid)
    {
        if(session('Atbl')){
            $tbl = session('Atbl');
        }
        else{
            $tbl = 1;
        }        
        $tb = 0;
        $mt = 0;
        $ps = 0;
        $us = 0;
        $chk = 0;
        $chk2 = 0;
        $machinetypes = $this->machinetypes;
        $linenames = $this->linenames;
        if($linid == 0 && $mid == 0){
            $lin = Feeder::where('model_id',$id)->groupBy('line_id')->pluck('line_id')->first();
            $machid = Feeder::where('model_id',$id)->groupBy('machine_type_id')->pluck('machine_type_id')->first();
        }
        else{
            $lin = $linid;
            if ($mid == 0) {
                $machid = Feeder::where('model_id',$id)->where('line_id',$linid)->groupBy('machine_type_id')->pluck('machine_type_id')->first();
            }
            else{
                $machid = $mid;
            }
        }


        /* if ($mid == 0) {
            $machid = Feeder::where('model_id',$id)->groupBy('machine_type_id')->pluck('machine_type_id')->first();
        }
        else{
            $machid = $mid;
        }
        if ($linid == 0) {
            $lin = Feeder::where('model_id',$id)->groupBy('line_id')->pluck('line_id')->first();
        }
        else{
            $lin = $linid;
        } */ 
        $model = ModName::where('id',$id)->first();
        $mounters = $this->mounters;
        $positions = $this->positions;
        $prefs = $this->prefs;
        $components = $this->components;
        
        return view('mes.pages.fld',compact(
            'model',
            'mt',
            'ps',
            'us',
            'tb',
            'mounters',
            'positions',
            'prefs',
            'components',
            'machid',
            'machinetypes',
            'linenames',
            'chk',
            'chk2',
            'lin',
            'tbl'
        ));
    }
    public function getmachtables($mach,$id)
    {   
        $tb = 0;
        $mt = 0;
        $ps = 0;
        $us = 0;
        $machid = $id;
        $mounters = $this->mounters;
        $model = ModName::where('id',$mach)->first();
        /* $mounters = Mounter::all(); */
        return view('mes.inc.table.mach',compact(
            'model',
            'mt',
            'ps',
            'us',
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
    public function lineconfig(Request $request)
    {
        $lines = LineName::whereIn('division_id',[2])->get();
        $mods = ModName::orderby('updated_at','DESC')->get();
        return view('mes.inc.table.lcTable',compact('mods','lines'));
    }
    public function lineconfigUpdate(Request $request)
    {
        $t = [];
        $lines = LineName::whereIn('division_id',[2])->pluck('id');
        $mods = ModName::all();
        $user = $request->updated_by;
        foreach ($mods as $mod) {
            $up = ModName::find($mod->id);
            foreach ($lines as $line) {
                $key = 'line_id_'.$line;
                if($request[$key] == $mod->id){
                    $ln = [];
                    $ln = $up->lines;
                    if (in_array($line,$ln) == false) {
                        $ln[] = "$line";
                    }                    
                    $up->lines = $ln;
                    /* if($user){
                        $up->updated_by = $user;
                    }  */                   
                    $up->save(['timestamps' => false]);
                }
                else{
                    $ln2 = [];
                    $ln2 = $up->lines;
                    foreach ($ln2 as $key => $value) {
                        if($value == $line){
                            unset($ln2[$key]);
                        }
                    }
                    $ln3 = array_values($ln2);  
                    $up->lines = $ln3;
                    $up->save(['timestamps' => false]);
                }
            }
        }
        /* return $request->updated_by; */
        return [
            'type' => 'success',
            'message' => 'Data Saved'
        ]; 
    }

    /* PROCESS */
    public function process(Request $request)
    {
        $divisions = Division::all();
        
        return view('mes.pages.pr',compact('divisions'));
    }
}