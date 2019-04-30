<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Defect extends Model
{
    use Sortable;

    protected $connection= 'mysql2';

    protected $table = 'dmc_defect_code';    

    public $sortable = ['id','division_id','DIVISION_CODE'];

    public function division()
    {
        return $this->belongsTo('App\Models\Division','division_id','DIVISION_ID');
    }
    public function defect1()
    {
        return $this->belongsTo('App\Models\DefectMat');
    }
}