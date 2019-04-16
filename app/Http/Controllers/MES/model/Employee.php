<?php

namespace App\Http\Controllers\MES\model;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Employee extends Model
{
    protected $connection= 'mysql2';

    protected $table = 'smt_employees';

    use Sortable;

    /* protected $fillable = ['id']; */

    public $sortable = ['id','fname','lname','repair','updated_at'];
}
