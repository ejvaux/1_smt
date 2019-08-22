<?php

namespace App\Http\Controllers\MES2\model;

use Illuminate\Database\Eloquent\Model;
class Qc extends Model
{
    //
    protected $connection= 'mysql';
    protected $table = 'lot';
    public $primaryKey ='id';
    //use Sortable;
    //public $sortable = ['code','name'];

    //Relation
    public function employee_rel_check()
    {
        //return $this->belongsTo('App\employee','checked_by');
        return $this->belongsTo('App\Http\Controllers\MES\model\User','checked_by','NO');
    }
    public function employee_rel_close()
    {
        //return $this->belongsTo('App\employee','closed_by');
        return $this->belongsTo('App\Http\Controllers\MES\model\Employee','closed_by');
    }
    public function employee_rel_create()
    {
        //return $this->belongsTo('App\employee','created_by');
        return $this->belongsTo('App\Http\Controllers\MES\model\Employee','created_by');
    }
    public function jo()
    {
        return $this->belongsTo('App\Models\WorkOrder','jo_id');
    }
    
}
