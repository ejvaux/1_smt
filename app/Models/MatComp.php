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

    public function component()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\Component','materials','id');
    }
}
