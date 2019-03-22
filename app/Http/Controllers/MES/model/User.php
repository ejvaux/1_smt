<?php

namespace App\Http\Controllers\MES\model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $connection= 'mysql2';

    protected $table = 'dmc_user_info';
}
