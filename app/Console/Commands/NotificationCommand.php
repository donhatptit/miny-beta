<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\Topics;
use LaravelFCM\Sender\FCMSender;
use LaravelFCM\Message\OptionsBuilder;


class NotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:send
                             {--type=all/single}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $type = $this->option('type');
        $result = [
            'success' => false,
            'message' => ''
        ];

        try{
            if ($type == 'all'){
                $this->sendAll();
                $result['success'] = true;
            }elseif ($type == 'single'){
                $this->sendOneDevice();
                $result['success'] = true;
            }else{
                $result['message'] = 'Not support';
            }

            $this->info(json_encode($result));
        }catch (\Exception $e){
            $result['message'] = $e->getMessage();

            $this->info(json_encode($result));
        }
    }

    public function sendAll(){
        $name_topic = 'allMessage';
        $title = 'Cunghocvui Title';
        $body = 'Cunghocvui Body';
        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)
            ->setSound('default');
        $arr_data = [
            'screenId'=>1,
            'screenName' => 'Chi tiet bai hoc',
            'contentId'=> 2,
            'contentName' => 'Soan bai ABC'
        ];
        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($arr_data);
        $data = $dataBuilder->build();

        $notification = $notificationBuilder->build();
        $topic = new Topics();
        $topic->topic($name_topic);
        $topicResponse = FCM::sendToTopic($topic, null, $notification, $data);

        return $topicResponse->isSuccess();
    }
    public function sendOneDevice(){
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder('my title');
        $notificationBuilder->setBody('Hello world')
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = "fUC66B4z01U:APA91bH_F-_Ba14zZKHak1b5NNo8y3WDSDkphLUzZ1T-RMI8lCyeB71VIZLmXCvMvCPV8EcRGZX2h8h1yIS_pAJeQUk153I13ETZHWNhtcxCD02ZACe0zMYVdxCBPAy4JZX5M1uY2pAb";

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
       return  $downstreamResponse->numberSuccess();
    }
}
