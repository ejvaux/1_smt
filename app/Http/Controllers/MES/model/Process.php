<?php

namespace App\Http\Controllers\MES\model;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{    
    protected $connection= 'mysql2';
    protected $table = 'smt_processes';

    public function division()
    {
        return $this->belongsTo('App\Models\Division','division_id','DIVISION_ID');
    }
    public function updatedBy()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\User','updated_by','NO');
    }
}
