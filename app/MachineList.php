<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MachineList extends Model
{
    //
    protected $table = 'scanrecord';
    public $primarykey = 'id';
    public $timestamps = true;
}
