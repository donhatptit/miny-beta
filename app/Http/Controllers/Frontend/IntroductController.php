<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IntroductController extends FrontendController
{
    public function index(){
        $desc = 'Hỗ trợ học tập, giải bài tập, tài liệu học tập Toán học, Văn học, Soạn văn, Tiếng Anh, Lịch sử, Địa lý, Giáo dục công dân';
        $this->setSeoMeta("Giới thiệu Cunghocvui",$desc);
        return view('frontend.home.introduct');
    }
}
