<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class MatComp extends Model
{
    protected $connection= 'smt_db';

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
    public function pcb()
    {
        return $this->hasMany('App\Models\Pcb','mat_comp_id');
    }
}
