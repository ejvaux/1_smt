<?php

namespace App\Http\Controllers\MES2\model;

use Illuminate\Database\Eloquent\Model;

class componentmonitoring extends Model
{
    //
    protected $connection= 'mysql';
    protected $table = 'component_monitoring';
    public $primaryKey ='id';
}


