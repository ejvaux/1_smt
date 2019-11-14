<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatLoadModel extends Model
{
    //
    
    protected $table = 'mat_load_history';
    public $primarykey = 'id';
    public $timestamps = true;

    public function machine_rel()
    {
        return $this->belongsTo('App\machine','machine_id');
    }

    public function smt_model_rel()
    {
        return $this->belongsTo('App\modelSMT','model_id');
    }

    public function smt_table_rel()
    {
        return $this->belongsTo('App\tableSMT','table_id');
    }

    public function mounter_rel()
    {
        return $this->belongsTo('App\mounter','mounter_id');
    }

    public function smt_pos_rel()
    {
        return $this->belongsTo('App\LRPosition','pos_id');
    }
    public function component_rel()
    {
        return $this->belongsTo('App\component','component_id');
    }
    public function order_rel()
    {
        return $this->belongsTo('App\orderSMT','order_id');
    }
    public function employee_rel()
    {
        return $this->belongsTo('App\employee','employee_id');
    }
    public function machine()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\Machine','machine_id');
    }
    public function model()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\ModName','model_id');
    }
}
