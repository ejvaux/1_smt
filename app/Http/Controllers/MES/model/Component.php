<?php

namespace App\Http\Controllers\MES\model;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Component extends Model
{
    protected $connection= 'mysql2';

    protected $table = 'smt_components';

    use Sortable;

    /* protected $fillable = ['id']; */

    public $sortable = ['id'];
}
