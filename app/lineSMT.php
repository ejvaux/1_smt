<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class lineSMT extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'smt_lines';
    public $primarykey = 'id';
    public $timestamps = true;
}
