<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class MatSnComp extends Model
{
    /* protected $connection= 'smt_db2'; */

    protected $table = 'mat_sn_comps';

    use Sortable;

    public $sortable = ['id'];

    protected $casts = [
        'sn' => 'array',
    ];
    public function model()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\ModName','model_id');
    }
    public function line()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\LineName','line_id');
    }
    public function component()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\Component','component_id');
    }
    public function matcomp()
    {
        return $this->belongsTo('App\Models\MatComp','mat_comp_id');
    }
}
