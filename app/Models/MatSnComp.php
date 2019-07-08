<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class MatSnComp extends Model
{
    protected $table = 'mat_sn_comps';

    use Sortable;

    public $sortable = ['id'];

    protected $casts = [
        'sn' => 'array',
    ];
}