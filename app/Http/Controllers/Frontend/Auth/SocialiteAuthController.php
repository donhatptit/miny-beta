<?php

namespace App\Http\Controllers\Frontend\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteAuthController extends Controller
{
    /** @todo SocialiteAuthController */

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider){
        try{
            $user =  Socialite::driver($provider)->user();
            dd($user);

//            $infoUser = $this->findOrCreateUser($provider,$user);
//            Auth::login($infoUser,true);
//            dd(Auth::user());
        }catch (\Exception $e){
            return redirect()->route('home');
        }
    }

    private function findOrCreateUser($provider,$data){
        $social_columns = '';
        switch ($provider){
            case 'google' :
                $social_columns = 'google_id';
                break;
            case 'facebook' :
                $social_columns = 'facebook_id';

        }
        if($social_columns !== ''){
            if($data->email == null){
                $data->email = $data->id. '@' . $provider . 'com';
            }
            $getUser =  User::where('email',$data->email)->first();
            if(empty($getUser)){
                $user = User::create([
                    'name' => $data->name,
                    'email' => $data->email,
                    $social_columns => $data->id,
                ]);
                return $user;

            }else{
                return $getUser;
            }
        }
    }
}
