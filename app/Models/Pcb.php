<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Pcb extends Model
{
    protected $table = 'pcb';

    use Sortable;

    /* protected $fillable = ['id']; */

    public $sortable = ['id','updated_by','updated_at'];
}
