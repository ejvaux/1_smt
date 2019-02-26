<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SAPPlanModel extends Model
{
    //
    protected $connection = 'sqlsrv';
    protected $table = 'OWOR';
    public $primarykey = 'DocEntry';

    public function scanrecordlink()
    {
        return $this->hasMany('App\scanrecordlist','DocEntry','SapPlanID');
    }
    
}
