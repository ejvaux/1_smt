<?php

namespace App\Custom;

use App\Models\Division;
use App\Models\Lot;
use App\Http\Controllers\MES\model\LineName;

/* Models for component monitoring */
//use App\Http\Controllers\MES\model\LineName;
use App\ProdLine;
use App\component;
use App\ProcessList;
use App\errorcodelist;
use App\modelSMT;
use App\LRPosition;
use App\mounter;
use App\employee;
use App\machine;
use App\lineSMT;

use App\tableSMT;

use Nexmo\Message\Shortcode\Alert;
/* Using component monitoring models */
use App\RunningOnMachine;
use App\Http\Controllers\MES2\model\componentmonitoring;
use App\Http\Controllers\MES2\model\componentqty;


class CustomFunctions
{
    public static function plural($n){
        if($n > 1){
            return 's';
        }
    } 
    public static function datelapse($dt){
        $date1 = strtotime($dt);
        $date2 = strtotime(date('Y-m-d H:i:s'));
        $secs = $date2 - $date1;
        if($secs < 60){
            return $secs . " secs ago";
        }
        elseif($secs >= 60 && $secs < 3600){
            $a = floor($secs / 60);            
            if($a>1){
                return $a . " mins ago";
            }
            else{
                return $a . " min ago";
            }              
        }
        elseif($secs >= 3600 && $secs < 86400){
            $a = floor($secs / 3600);
            if($a>1){
                return $a . " hours ago";
            }
            else{
                return $a . " hour ago";
            }
        }
        elseif($secs >= 86400){
            $a = floor($secs / 86400);
            if($a>1){
                return $a . " days ago";
            }
            else{
                return $a . " day ago";
            } 
        }
    }
    public static function datefinished($dt1,$dt2){
        $date1 = strtotime($dt1);
        $date2 = strtotime($dt2);
        $secs = $date2 - $date1;              
        $days = floor($secs / (3600*24));
        $secs  -= $days*3600*24;
        $hrs   = floor($secs / 3600);
        $secs  -= $hrs*3600;
        $mnts = floor($secs / 60);
        $secs  -= $mnts*60;
        /* $time = $days . " day, " . $hrs . " hr, " . $mnts . " min"; */
        $time = '';
        if($days > 0){
            $time = $days . " day" . CustomFunctions::plural($days);
            if($hrs > 0){
                $time .= ", ". $hrs . " hr" . CustomFunctions::plural($hrs);
            }
        }
        else{
            if($hrs > 0){
                $time .= $hrs . " hr" . CustomFunctions::plural($hrs);
                if($mnts > 0){
                    $time .= ", ". $mnts . " min" . CustomFunctions::plural($mnts);
                }
            }
            else{
                if($mnts > 0){
                    $time .= $mnts . " min" . CustomFunctions::plural($mnts);
                }
            }
            
        }        
        if($secs > 0 && $mnts <= 0 && $hrs <= 0 && $days <= 0){
            $time .= $secs . " sec" . CustomFunctions::plural($secs);
        }
        return $time;
    }
    public static function genshift(){
        $date = Date('H:i');
        $shift = '';
        if($date > '05:59' && $date < '18:00'){
            $shift = 1;
        }
        else if($date >= '18:00' || $date < '06:00'){
            $shift = 2;
        }
        else{
            $shift = 0;
        }
        return $shift;
    }
    public static function colorsets(){
        
        $col =[
            '#99A3A4',
            '#42a5f5',
            '#5c6bc0',
            '#7e57c2',
            '#ab47bc',
            '#ec407a',
            '#ef5350',
            '#d4e157',
            '#9ccc65',
            '#66bb6a',
            '#26a69a',
            '#26c6da',
            '#29b6f6',
            '#bdbdbd',
            '#8d6e63',
            '#ff7043',
            '#ffa726',
            '#ffee58',
            '#ffca28',
            '#78909C'
        ];
        return $col;
    }
    public static function genlotnumber($div_id,$line_id){
        $ln = '';
        $d = 0;

        // Division
        $div = Division::where('DIVISION_ID',$div_id)->first();
        $dv = sprintf("%02d", $div->SAP_DIVISION_CODE);
        $ln .= $dv;

        // Line
        if($div_id == 2){
            $line = LineName::where('id',$line_id)->first();
            $l = substr($line->name,4);
            $l = sprintf("%02d", $l);
            $ln .= $l;
        }
        elseif($div_id == 17 || $div_id == 18){
            $line = LineName::where('id',$line_id)->first();
            $l = substr($line->name,4);
            $l = sprintf("%02d", $l);
            $ln .= $l;
        }
        else{
            $ln .= 'XX';
        }

        // Year
        $cur_year = Date('y');
        $ln .= $cur_year;

        // Month
        $cur_month = CustomFunctions::convertmonth(Date('m'));
        $ln .= $cur_month;

        // Date
        if(Date('H:i') >= '06:00'){
            $d = 1;
            $cur_date = Date('d');
        }
        else{
            $cur_date = Date('d', strtotime('-1 day', strtotime(Date('Y-m-d'))));
        }        
        $ln .= $cur_date;

        // Shift
        $cur_shift = CustomFunctions::genshift();
        $ln .= $cur_shift;

        // Number          
        $last_num = Lot::where('created_at','like',Date('Y-m-d').'%')->orderBy('id','DESC')->first();
        if($last_num){
            $last = substr($last_num->number,-2)+1;
            $ln .= sprintf("%02d",$last);
        }
        else{
            $ln .= '01';
        }

        return $ln;
    }
    public static function convertmonth($mnth){
        $months  = [
            '10' => 'A',
            '11' => 'B',
            '12' => 'C'
        ];
        $m = '';
        foreach ($months as $key => $value) {
            if($mnth == $key){
                $m = $value;
            }
        }
        if($m != ''){
            return $m;
        }
        else{
            return substr($mnth,-1);
        }
    }
    public static function getmachcode($machine){
        $m_code =substr($machine,0,-1);
        $m_code = substr($m_code,0,-2) . '-' . substr($m_code,-2);
        return strtoupper($m_code);
    }
    public static function getmachtable($machine){
        $table=substr($machine,-1);
        return $table_id= tableSMT::where('name',$table)->pluck('id')->first();
    }

}