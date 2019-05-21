<?php

namespace App\Http\Controllers\MES\model;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Feeder extends Model
{
    protected $connection= 'mysql2';

    protected $table = 'smt_feeders';

    use Sortable;

    /* protected $fillable = ['id']; */

    public $sortable = ['id'];

    public function model()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\ModName','model_id');
    }
    public function machinetype()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\MachineType','machine_type_id');
    }
    public function line()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\LineName','line_id');
    }
    public function mounter()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\Mounter','mounter_id');
    }
    public function position()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\Position','pos_id');
    }
    public function preference()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\Preference','order_id');
    }
    public function component()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\Component','component_id');
    }
}