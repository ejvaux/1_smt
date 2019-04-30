<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Process extends Model
{
    protected $connection= 'mysql2';

    protected $table = 'smt_processes';

    use Sortable;

    public $sortable = ['id'];
}
