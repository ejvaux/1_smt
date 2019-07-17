<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Pcb extends Model
{
    protected $table = 'pcb';

    use Sortable;

    /* protected $fillable = ['id']; */

    public $sortable = ['id','updated_by','updated_at'];

    public function division()
    {
        return $this->belongsTo('App\Models\Division','division_id','DIVISION_ID');
    }
    public function line()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\LineName','line_id');
    }
    public function divprocess()
    {
        return $this->belongsTo('App\Models\DivProcess','div_process_id');
    }
    public function employee()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\Employee','employee_id');
    }
    public function workorder()
    {
        return $this->belongsTo('App\Models\WorkOrder','jo_id','ID');
    }
    public function mat_comp()
    {
        return $this->belongsTo('App\Models\MatComp','mat_comp_id','id');
    }
}
