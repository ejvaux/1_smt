<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class component extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'smt_components';
    public $primarykey = 'id';
    public $timestamps = true;
}
