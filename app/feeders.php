<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class feeders extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'smt_feeders';
    public $primarykey = 'id';
    public $timestamps = true;



    public function machine_type_rel()
    {
        return $this->belongsTo('App\machineType','machine_type_id');
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
}

