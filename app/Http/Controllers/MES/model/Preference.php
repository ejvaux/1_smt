<?php

namespace App\Http\Controllers\MES\model;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Preference extends Model
{
    protected $connection= 'mysql2';

    protected $table = 'smt_orders';

    use Sortable;

    /* protected $fillable = ['id']; */

    public $sortable = ['id'];
}
