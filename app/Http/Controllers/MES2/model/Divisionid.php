<?php

namespace App\Http\Controllers\MES2\model;

use Kyslik\ColumnSortable\Sortable;

use Illuminate\Database\Eloquent\Model;



class Divisionid extends Model
{
    //
    protected $connection= 'mysql2';
    protected $table = 'dmc_division_code';
    public $primaryKey ='DIVISION_ID';
    use Sortable;
    public $sortable = ['code'];

}
