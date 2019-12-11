<?php

namespace App\Http\Controllers\MES\model;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class MachineType extends Model
{
    protected $connection= 'mysql2';

    protected $table = 'smt_machine_types';

    use Sortable;

    /* protected $fillable = ['id']; */

    public $sortable = ['id'];    

    public function machine()
    {
        return $this->hasmany('App\Http\Controllers\MES\model\Machine'/* ,'id','machine_type_id' */);
    }
}
