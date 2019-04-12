<?php

namespace App\Http\Controllers\MES\model;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class LineName extends Model
{
    protected $connection= 'mysql2';

    protected $table = 'smt_line_names';

    use Sortable;

    public $sortable = ['id','name'];
}
