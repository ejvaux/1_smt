<?php

namespace App\Custom;

class CustomFunctions
{   
    public static function datetimelapse($dt){
        $datetime1 = strtotime($dt);
        $datetime2 = strtotime(date('Y-m-d H:i:s'));
        $secs = $datetime2 - $datetime1;
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
    public static function datetimefinished($dt1,$dt2){
        $datetime1 = strtotime($dt1);
        $datetime2 = strtotime($dt2);
        $secs = $datetime2 - $datetime1;              
        $days = floor($secs / (3600*24));
        $secs  -= $days*3600*24;
        $hrs   = floor($secs / 3600);
        $secs  -= $hrs*3600;
        $mnts = floor($secs / 60);
        $secs  -= $mnts*60;
        /* $time = $days . " day, " . $hrs . " hr, " . $mnts . " min"; */
        $time = '';
        if($days > 0){
            $time = $days . " day, ";
        }
        if($hrs > 0){
            $time .= $hrs . " hr, ";
        }
        if($mnts > 0){
            $time .= $mnts . " min";
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
}