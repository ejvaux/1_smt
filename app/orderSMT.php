<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class orderSMT extends Model
{
    //

    protected $connection = 'mysql2';
    protected $table = 'smt_orders';
    public $primarykey = 'id';
    public $timestamps = true;


}
