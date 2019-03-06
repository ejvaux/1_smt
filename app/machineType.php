<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class machineType extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'smt_machine_types';
    public $primarykey = 'id';
    public $timestamps = true;
}
