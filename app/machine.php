<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class machine extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'smt_machines';
    public $primarykey = 'id';
    public $timestamps = true;
}
