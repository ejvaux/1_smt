<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class scanrecordlist extends Model
{
    //
    protected $table = 'scanrecord';
    public $primarykey = 'id';
    public $timestamps = true;

    public function userlink()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function errorlink()
    {
        return $this->belongsTo('App\errorcodelist','error_id');
    }
    public function prodlinelink()
    {
        return $this->belongsTo('App\ProdLine','prodline_id');
    }
    public function processlink()
    {
        return $this->belongsTo('App\ProcessList','process_id');
    }
    public function machinelink()
    {
        return $this->belongsTo('App\MachineList','machine_id');
    }



}
