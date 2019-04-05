<?php

namespace App\Http\Controllers\MES\model;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Machine extends Model
{
    protected $connection= 'mysql2';

    protected $table = 'smt_machines';

    use Sortable;

    public $sortable = ['id'];
}
