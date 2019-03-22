<?php

namespace App\Http\Controllers\MES\model;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ModName extends Model
{
    protected $connection= 'mysql2';

    protected $table = 'smt_models';

    use Sortable;

    /* protected $fillable = ['id']; */

    public $sortable = ['id',
                        'code',
                        'program_name',
                        'revision',
                        'updated_by',
                        'updated_at'];    

    public function updatedBy()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\User','updated_by','NO');
    }
}
