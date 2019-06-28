<?php
/**
 * Created by PhpStorm.
 * User: TinyPoro
 * Date: 9/20/18
 * Time: 10:13 AM
 */

namespace App\Colombo\Cache\Manager;

class MyCache
{
    public static function get($config, $force = false, $param = null){
        if(!is_array($config)){
            return null;
        }
        if($param == null){
            $key = $config['name'];
        }else{


            $key = $config['name'] . '_' . $param;
        }
        if(\Cache::has($key)) {
            $value = \Cache::get($key);
        }else{
            $value = null;
        }
        if($value == null || count($value) == 0){
            if ($force == true || array_get($config,'force', false)){
                self::store($config, $param);
                $value = \Cache::get($key);
            }
        }
        return $value;
    }

    public static function refresh($config, $force = false, $param = null){

        return self::store($config, $param);
    }

    public static function store($config, $param){
        try{
            if($param == null){
                $key = $config['name'];
            }else{
                $key = $config['name'] . '_' . $param;
            }
            $value_cache = call_user_func_array(array($config['class'], $config['refresh_method']),
                []);
            \Cache::put($key, $value_cache, $config['timeout']);
            if(\Cache::has($key)){
                return true;
            }else{
                return false;
            }
        } catch (\Exception $ex){
            return false;
        }
    }
}