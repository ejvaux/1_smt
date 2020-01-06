<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatSnCompsArchive extends Model
{
    protected $table = 'mat_sn_comps_archives';

    protected $casts = [
        'sn' => 'array',
    ];

    protected $fillable = ['id','created_at','updated_at'];

    public function model()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\ModName','model_id');
    }

    public function line()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\LineName','line_id');
    }

    public function component()
    {
        return $this->belongsTo('App\Http\Controllers\MES\model\Component','component_id');
    }
    
    public function matcomp()
    {
        return $this->belongsTo('App\Models\MatComp','mat_comp_id');
    }
}
