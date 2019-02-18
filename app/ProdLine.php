<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdLine extends Model
{
    //
    protected $table = 'prodline';
    public $primarykey = 'id';
    public $timestamps = true;
}
