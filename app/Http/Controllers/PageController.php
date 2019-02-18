<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\ProdLine;
use App\ProcessList;
class PageController extends Controller
{
    //
    public function scan()
    {
        $pline=ProdLine::all();
        $processlist=ProcessList::all();
        $ipAdd=$this->getIp();
        return view('pages.scan.scanpage',compact('pline','processlist','ipAdd'));
    }
    public function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
    }
}
