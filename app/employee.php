<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'smt_employees';
    public $primarykey = 'id';
    public $timestamps = true;
}
