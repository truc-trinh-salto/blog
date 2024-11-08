<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Contracts\Cache\Repository as Cache;

class CacheController extends Controller
{
    protected $cache;

    public function __construct( Cache $cache)
    {
        $this->cache = $cache;
    }

    public function pull(){

    }

    public function put(){

    }

    
    public function add(){
        $this->cache->add('number',0);
    }


    public function increment($value = 2){
        $this->cache->increment('number',$value);
    }

    
    public function decrement(){

    }

    
    public function forever(){

    }


    public function remember(){

    }

    
    public function sear(){

    }

    public function rememberForever(){

    }

    
    public function forget(){

    }


    public function getStore(){

    }


}
