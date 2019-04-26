<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Division extends Model
{
    protected $connection= 'mysql2';

    protected $table = 'dmc_division_code';

    use Sortable;

    public $sortable = ['DIVISION_ID'];
}
