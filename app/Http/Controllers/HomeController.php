<?php

namespace App\Http\Controllers;

use App\Models\Demoposts;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('home');
    }

    public function detail($id)
    {
        $post = Demoposts::where('id', $id)->first();
        return view('home', ['post' => $post]);
    }
}
