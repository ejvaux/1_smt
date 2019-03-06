<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class feeders extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'smt_feeders';
    public $primarykey = 'id';
    public $timestamps = true;
}
