<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\TokenDevice;
use App\Responses\Meta;
use App\Responses\ResObj;
use App\Responses\Response;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class NotificationController extends Controller
{
    public function storeTokenDevice(Request $request){
        $token = $request->get('token');
        $auth_key = $request->header('authorization');
        $user = User::getUserFromAuthKey($auth_key);
        if(!$user){
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }
        $token_device = TokenDevice::where('token_device',$token)->first();
        if(!$token_device){
            $store = TokenDevice::create([
                'user_id' => $user->id,
                'token_device' => $token
            ]);
            if ($store){
                $meta = new Meta(200);
            }else{
                $meta = new Meta(400);
            }
        }else{
            $meta = new Meta(200);
        }
        $response = new Response();
        $resObj = new ResObj($meta, $response);

        return response()->json($resObj);
    }
    public function deleteTokenDevice(Request $request){
        $token = $request->get('token');
        $auth_key = $request->header('authorization');
        $user = User::getUserFromAuthKey($auth_key);
        if(!$user){
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }
        $status = TokenDevice::where('token_device',$token)->delete();
        if ($status){
            $meta = new Meta(200);
        }else{
            $meta = new Meta(400);
        }
        $response = new Response();
        $resObj = new ResObj($meta, $response);

        return response()->json($resObj);
    }
    public function sendNotification(){
       $code = Artisan::call('notification:send', [
            '--type' => 'all',
        ]);

       if($code === 0){
           //không có lỗi
           $output = Artisan::output();
           $output = trim($output);
           $output = json_decode($output);

           if($output->success){
               $meta = new Meta(200);
           }else{
               $meta = new Meta(400, $output->message);

           }
       }else{
           $meta = new Meta(400);
       }

       $response = new Response();
       $resObj = new ResObj($meta, $response);

       return response()->json($resObj);
    }
}
