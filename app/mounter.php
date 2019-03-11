<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mounter extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'smt_mounters';
    public $primarykey = 'id';
    public $timestamps = true;
}
