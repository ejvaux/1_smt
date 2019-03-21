<?php

namespace App\Http\Controllers\MES\model;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Position extends Model
{
    protected $connection= 'mysql2';

    protected $table = 'smt_pos';

    use Sortable;

    /* protected $fillable = ['id']; */

    public $sortable = ['id'];
}
