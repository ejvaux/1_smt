<?php

namespace App\Http\Controllers\MES\model;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Mounter extends Model
{
    protected $connection= 'mysql2';

    protected $table = 'smt_mounters';

    use Sortable;

    /* protected $fillable = ['id']; */

    public $sortable = ['id'];
}
