<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Defect extends Model
{
    protected $connection= 'mysql2';

    protected $table = 'dmc_defect_code';

    use Sortable;

    public $sortable = ['id'];

    public function division()
    {
        return $this->belongsTo('App\Models\Division','division_id','DIVISION_ID');
    }
}