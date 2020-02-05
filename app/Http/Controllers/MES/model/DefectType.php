<?php

namespace App\Http\Controllers\MES\model;

use Illuminate\Database\Eloquent\Model;

class DefectType extends Model
{
    
    protected $connection= 'mysql2';
    protected $table = 'smt_defect_types';
}
