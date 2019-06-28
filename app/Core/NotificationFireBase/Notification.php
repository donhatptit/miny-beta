<?php
/**
 * Created by PhpStorm.
 * User: huyptit
 * Date: 14/09/2018
 * Time: 16:41
 */

namespace App\Core\NotificationFireBase;

use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\Topics;


class Notification extends AbstractNotification
{
    protected $title;
    protected $body;

    public function __construct($title, $body)
    {
        $this->title = $title;
        $this->body = $body;
    }
    public function sendToTopic($nameTopic){
        $notification = $this->buildNotification($this->title,$this->body);
        $option = $this->buildOption(1200);
        $data = $this->buildData();
        $topic = new Topics();
        $topic->topic($nameTopic);
        $topicResponse = FCM::sendToTopic($topic, $option, $notification, $data);
        return $topicResponse->isSuccess();
    }
    public function sendToDevice($token){
        $res = [
            'success' => false,
            'number_fail' => 0,
        ];
        $notification = $this->buildNotification($this->title,$this->body);
        $option = $this->buildOption(1200);
        $data = $this->buildData();
        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
        $num_fail = $downstreamResponse->numberFailure();
        if($num_fail == 0){
            $res['success'] = true;
        }else{
            $res['number_fail'] = $num_fail;
        }
        return $res;
    }
}