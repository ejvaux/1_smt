<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialCount extends Model
{
    protected $fillable = ['model_id','line_id','feeder_id','mat_load_id','usage','reel_qty','sn','remaining_qty'];

    public function feeder()
    {
        return $this->belongsto('App\Http\Controllers\MES\model\Feeder','feeder_id');
    }
    public function matload()
    {
        return $this->belongsto('App\MatLoadModel','mat_load_id');
    }
    public function model()
    {
        return $this->belongsto('App\Http\Controllers\MES\model\ModName','model_id');
    }
    public function line()
    {
        return $this->belongsto('App\Http\Controllers\MES\model\LineName','line_id');
    }
}
