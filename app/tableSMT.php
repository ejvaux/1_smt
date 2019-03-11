<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tableSMT extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'smt_tables';
    public $primarykey = 'id';
    public $timestamps = true;
}
