<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class DefectMat extends Model
{
    protected $table = 'defect_mats';

    protected $casts = [
        'd_locations' => 'json'
    ];

    use Sortable;

    protected $fillable = ['d_locations','remarks','repair_by','repair','repaired_at'];

    public $sortable = [
        'id',
        'pcb_id',
        'division_id',
        'defect_id',
        'defected_at',
        'process_id',
        'employee_id',
        'line_id',
        'shift',
        'repaired_by',
        'repair',
        'updated_by',
        'updated_at',
        'created_at'
    ];

    public function pcb()
    {
        return $this->belongsTo('App\Models\Pcb','pcb_id');
    }    
    public function defect()
    {
        return $this->belongsTo('App\Models\Defect','defect_id','DEFECT_ID');
    }
    public function process()
    {
        return $this->belongsTo('App\Models\Process','process_id');
    }
    public function employee()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\Employee','employee_id');
    }
    public function line()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\LineName','line_id');
    }
    public function repairby()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\Employee','repair_by');
    }
    public function defectType()
    {
        return $this->belongsTo('App\Models\DefectType','defect_type_id');
    }
    public function division()
    {
        return $this->belongsTo('App\Models\Division','division_id','DIVISION_ID');
    }
}
