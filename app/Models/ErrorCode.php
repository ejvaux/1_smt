<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ErrorCode extends Model
{
    protected $connection= 'mysql2';

    protected $table = 'smt_error_codes';

    use Sortable;

    public $sortable = ['id','barcode','type_id','grade_id','name','description','updated_by','updated_at'];
}
