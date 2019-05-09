<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class WorkOrder extends Model
{
    protected $connection= 'mysql2';

    protected $table = 'mis_prod_plan_dl';

    use Sortable;

    public $sortable = ['JOB_ORDER_NO','ITEM_CODE','ITEM_NAME','MACHINE_CODE'];
}
