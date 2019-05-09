<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class DivProcess extends Model
{
    protected $connection= 'mysql2';

    protected $table = 'smt_div_processes';

    use Sortable;

    public $sortable = ['id','name','division_id'];
}
