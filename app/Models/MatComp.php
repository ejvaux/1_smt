<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class MatComp extends Model
{
    protected $table = 'mat_comps';

    use Sortable;

    public $sortable = ['id'];

    protected $casts = [
        'materials' => 'array',
    ];
}
