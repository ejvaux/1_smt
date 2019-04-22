<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ErrorType extends Model
{
    protected $connection= 'mysql2';

    protected $table = 'smt_error_types';

    use Sortable;

    public $sortable = ['id','name','updated_by','updated_at'];
}
