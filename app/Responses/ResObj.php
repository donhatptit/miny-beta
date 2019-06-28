<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 8/8/18
 * Time: 4:29 PM
 */

namespace App\Responses;


class ResObj
{
    public $meta;
    public $response;

    public function __construct(Meta $meta, Response $response){
        $this->meta = $meta;
        $this->response = $response;
    }
}