<?php

namespace App\Http\Controllers\MES2\model;

use Illuminate\Database\Eloquent\Model;

class Qc extends Model
{
    //
    protected $connection= 'mysql';
    protected $table = 'pcb';
    public $primaryKey ='id';
    //use Sortable;
    //public $sortable = ['code','name'];
}
