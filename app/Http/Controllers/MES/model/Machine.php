<?php

namespace App\Http\Controllers\MES\model;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Machine extends Model
{
    protected $connection= 'mysql2';

    protected $table = 'smt_machines';

    use Sortable;

    public $sortable = ['id','code','machine_type_id','line_id'];

    public function line()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\Line','line_id');
    }

    public function type()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\MachineType','machine_type_id');
    }
}
