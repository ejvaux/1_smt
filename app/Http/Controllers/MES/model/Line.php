<?php

namespace App\Http\Controllers\MES\model;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Line extends Model
{
    protected $connection= 'mysql2';

    protected $table = 'smt_lines';

    use Sortable;

    public $sortable = ['id','code','machine_id'];

    public function machine()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\Machine','machine_id');
    }
    public function linename()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\LineName','line_name_id');
    }
}
