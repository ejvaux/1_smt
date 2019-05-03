<?php

namespace App\Http\Controllers\MES2\model;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;


class DefectType extends Model
{
    //
    protected $connection= 'mysql2';
    protected $table = 'smt_defect_types';
    public $primaryKey ='id';
    use Sortable;
    public $sortable = ['code','name'];

}
