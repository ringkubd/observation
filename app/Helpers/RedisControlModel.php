<?php


namespace App\Helpers;

use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Model;
use DB;

class RedisControlModel extends Model
{
    private $rediskeys;
    private $dataQuery;
    private $destroyCache;
    private $querySelect;
    private $redisQuery;
    protected $queryId;
    private $queryTable;

    /**
     * @param string $query
     * @param bool $destroy
     * @param string $select
     */

    public function setParam($query = "",$table = null,$destroy = false,$select = "*")
    {
        $this->queryTable = $table ?? $this->table;
        $this->rediskeys = env("APP_NAME")."_".$this->table."_".get_called_class().$this->queryId;
        $this->dataQuery = $query;
        $this->destroyCache = $destroy;
        $this->querySelect = $select;
    }



    /**
     * @param $query
     * @return false|string
     */

    public function compailedQuery($query){
        $table = $this->queryTable ?? $this->table;
        $queryKeys = env("APP_NAME")."_".$this->table."_query_".get_called_class().$this->queryId;
        $q = $this->redisQuery($query);
        return json_encode(DB::select(DB::raw("SELECT * FROM $table $this->redisQuery")));

    }

    /**
     * @param $query
     * @return $this
     */

    private function redisQuery($query){
        $queryKeys = env("APP_NAME")."_".$this->table."_query_".get_called_class().$this->queryId;
        if (Redis::exists($queryKeys) && Redis::get($queryKeys) == $query){
            $this->redisQuery = Redis::get($queryKeys);
            return $this;
        }else{
            Redis::set($queryKeys,$query);
            $this->redisQuery = Redis::get($queryKeys);
            return $this;
        }
    }

    /**
     * Get parent branches
     */

    public function getFromDB(){
        $rediskeys = env("APP_NAME")."_".$this->table."_".get_called_class().$this->queryId;
        if (!Redis::exists($rediskeys) || $this->destroyCache) {
            $data = $this->compailedQuery($this->dataQuery);
            $storeInCache = Redis::set("$rediskeys",$data);
            return Redis::get($rediskeys);

        }else{
            return Redis::get($rediskeys);
        }
    }

    /**
     * UPDATE data onchange
     * @return boolean;
     */
    public function updateOnChange(){
        $rediskeys = env("APP_NAME")."_".$this->table."_".get_called_class().$this->queryId;
        return Redis::del($rediskeys);
    }

    /**
     * GET settings object
     * Settings cache decode;
     * @return object;
     */

    public function getFromRedis(){
        $rediskeys = env("APP_NAME")."_".$this->table."_".get_called_class().$this->queryId;
        $data = $this->getFromDB();
        return json_decode($data);
    }



}
