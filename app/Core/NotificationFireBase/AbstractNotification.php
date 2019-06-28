<?php
/**
 * Created by PhpStorm.
 * User: huyptit
 * Date: 14/09/2018
 * Time: 17:11
 */

namespace App\Core\NotificationFireBase;

use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\OptionsBuilder;


abstract class AbstractNotification
{


    protected  $screenId;
    protected  $screenName;
    protected  $contentId;
    protected  $contentName;


    public function setData($screenId,$screenName,$contentId,$contentName){
        $this->screenId = $screenId;
        $this->screenName = $screenName;
        $this->contentId = $contentId;
        $this->contentName = $contentName;
    }
    public function dataToArray(){
        return [
            'screenId' => $this->screenId,
            'screenName' => $this->screenName,
            'contentId' => $this->contentId,
            'contentName' => $this->contentName
        ];
    }

    public function buildData(){
        $data = $this->dataToArray();
        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($data);
        return $dataBuilder->build();
    }

    public function buildNotification($title,$body){
        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)
            ->setSound('default');
        return $notificationBuilder->build();
    }
    public function buildOption($time_live){
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive($time_live);
        return $optionBuilder->build();
    }

}