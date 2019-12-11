<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialCount extends Model
{
    protected $fillable = ['model_id','line_id','feeder_id','mat_load_id','usage','reel_qty','sn','remaining_qty'];

    public function feeder()
    {
        return $this->hasMany('App\Http\Controllers\MES\model\Feeder','feeder_id');
    }
    public function matload()
    {
        return $this->hasMany('App\MatLoadModel','mat_load_id');
    }
    public function model()
    {
        return $this->hasMany('App\Http\Controllers\MES\model\ModName','model_id');
    }
    public function line()
    {
        return $this->hasMany('App\Http\Controllers\MES\model\LineName','line_id');
    }
}
