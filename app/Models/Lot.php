<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Lot extends Model
{
    protected $table = 'lot';

    use Sortable;

    public $sortable = ['id','name','jo_id'];
}
