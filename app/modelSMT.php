<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class modelSMT extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'smt_models';
    public $primarykey = 'id';
    public $timestamps = true;
}
