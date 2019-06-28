<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 8/8/18
 * Time: 4:29 PM
 */

namespace App\Responses;


class Meta
{
    public $code;
    public $msg;

    protected $msg_array = [
        200 => "OK",
        400 => "Bad Request",
        401 => "Unauthorized",
    ];

    public function __construct($code = 200, $msg = null){
        $this->code = $code;

        $this->msg = ($msg) ? $msg : $this->getMsgTextAttribute();
    }

    public function getMsgTextAttribute(){
        return array_get($this->msg_array, $this->code, 'N/A');
    }
}