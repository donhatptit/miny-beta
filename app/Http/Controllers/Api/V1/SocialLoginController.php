<?php

namespace App\Http\Controllers\Api\V1;

use App\Repositories\Backend\Auth\UserRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Responses\Meta;
use App\Responses\ResObj;
use App\Responses\Response;
use Illuminate\Support\Facades\Auth;

class SocialLoginController extends Controller
{
    private $client;
    private $userRepository;

    /** $userRepository UserRepository */

    public function __construct(UserRepository $userRepository)
    {
        $this->client = new \GuzzleHttp\Client();
        $this->userRepository = $userRepository;
    }

    public function registerOrLogin($provider,Request $request){
        $meta = new Meta(400);
        $response = new Response();
        $resObj = new ResObj($meta,$response);
        try{
            if(!empty($provider)){
                if(!empty($request->token)){
                    $res = $this->client->request('GET',$this->makeRequest($provider,$request->token));
                    $contents = json_decode($res->getBody()->getContents());
                    $info = $this->genInfoUser($contents,$provider);
                    $user = User::where('email',$info['email'])->first();
                    if(empty($user)){
                        $regUser = $this->createdUser($info,$provider);
                        if($regUser){
                            $this->userRepository->genApiToken($regUser->id);
                             $user_auth = User::findOrFail($regUser->id);
                            \Auth::login($user_auth);
                             return $this->responseInfo($user_auth);
                        }
                        return response()->json($resObj);
                    }else{
                            \Auth::login($user);
                            return $this->responseInfo($user);
                    }

                }

            }
        }catch(\Exception $e){
            $meta = new Meta(400, $e->getMessage());
            $response = new Response();
            $resObj = new ResObj($meta, $response);
            return response()->json($resObj);
        }

    }
    private function createdUser($data,$provider){
        $column = $provider . '_id';
        $regUser = User::create([
            'email' => $data['email'],
            'name' =>$data['name'],
            $column =>$data[$column]
        ]);
        return $regUser;
    }
    private function makeRequest($provider, $token){
        return config('services.social.' . $provider). $token;
    }
    private function genInfoUser($data,$provider){
        $info = array();
        switch ($provider){
            case 'google':
                $info['name'] = $data->displayName;
                $info['google_id'] = $data->id;
                $info['email'] = $data->emails[0]->value;
                break;
            case 'facebook' :
                $info['name'] = $data->name;
                $info['facebook_id'] = $data->id;
                $info['email'] = $data->id .'@facebook.com';
        }
        return $info;
    }
    private function responseInfo($user){
        $meta = new Meta(200);
        $response = new Response();
        $response->setValue('name', $user->name);
        $response->setValue('email', $user->email);
        $response->setValue('token', $user->api_token);
        $resObj = new ResObj($meta, $response);
        return response()->json($resObj);
    }

}
