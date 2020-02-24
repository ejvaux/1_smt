<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class machine extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'smt_machines';
    public $primarykey = 'id';
    public $timestamps = true;

    public function machine_type_rel()
    {
        return $this->belongsTo('App\machineType','machine_type_id');
    }
    public function line_rel()
    {
        return $this->belongsTo('App\lineSMT','line_id');
    }
    public function line()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\Line','line_id');
    }
    public function line2()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\LineName','_line_id');
    }


}
