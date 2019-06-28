<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Backend\Auth\UserRepository;
use App\Http\Controllers\Controller;

class UserController extends Controller
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

    public function getApiToken(){
        $users = $this->userRepository->get();

        return view('admin.users.list_token', [
           'users' => $users
        ]);
    }

    public function genApiToken($id){
        $this->userRepository->genApiToken($id);
        return back();
    }
}
