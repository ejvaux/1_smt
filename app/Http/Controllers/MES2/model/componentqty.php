<?php

namespace App\Http\Controllers\MES2\model;

use Illuminate\Database\Eloquent\Model;

class componentqty extends Model
{
    //
    protected $connection= 'mysql';
    protected $table = 'component_qty';
    public $primaryKey ='id';
}