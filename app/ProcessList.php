<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcessList extends Model
{
    //
    protected $table = 'processlist';
    public $primarykey = 'id';
    public $timestamps = true;
}
