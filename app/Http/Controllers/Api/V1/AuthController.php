<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Auth\UserRepository;
use App\Responses\Meta;
use App\Responses\ResObj;
use App\Responses\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * ProfileController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(Request $request){
        try{
            $this->validator($request->json()->all())->validate();

            $user = $this->userRepository->create($request->json()->all());
            $this->userRepository->genApiToken($user->id);

            return $this->authenticate($request);
        }catch (\Exception $e){
            $meta = new Meta(400, $e->getMessage());
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $this->only($request, ['email', 'password']);

        if (Auth::attempt($credentials)) {
            $user = $this->userRepository->getUserByEmail($credentials['email']);

            $meta = new Meta(200);
            $response = new Response();
            $response->setValue('name', $user->name);
            $response->setValue('email', $user->email);
            $response->setValue('token', $user->api_token);
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        $meta = new Meta(401);
        $response = new Response();
        $resObj = new ResObj($meta, $response);

        return response()->json($resObj);
    }

    protected function only(Request $request, $keys){
        $data = [];

        foreach($keys as $key){
            $data[$key] = $request->json()->get($key);
        }

        return $data;
    }
}
