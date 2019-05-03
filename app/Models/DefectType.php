<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class DefectType extends Model
{
    protected $connection= 'mysql2';

    protected $table = 'smt_defect_types';

    use Sortable;

    public $sortable = ['id'];
}
