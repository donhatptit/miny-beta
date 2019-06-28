<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 8/8/18
 * Time: 4:28 PM
 */

namespace App\Responses;


class Response
{
    public function setValue($key, $value){
        $this->$key = $value;
    }
}