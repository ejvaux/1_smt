<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LRPosition extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'smt_pos';
    public $primarykey = 'id';
    public $timestamps = true;
}
