<?php

namespace App\Http\Controllers\Frontend;

use App\Colombo\Cache\Manager\MyCache;
use App\Models\TsPost;
use App\Models\University;
use App\Repositories\Frontend\Item\CategoryRepository;
use App\Repositories\Frontend\Item\PostRepository;

class HomeController extends FrontendController
{
    public function __construct(CategoryRepository $categoryRepository, PostRepository $postRepository)
    {
        parent::__construct($categoryRepository, $postRepository);
    }

    public function index(){

        $desc = 'Hỗ trợ học tập, giải bài tập, tài liệu học tập Toán học, Văn học, Soạn văn, Tiếng Anh, Lịch sử, Địa lý, Giáo dục công dân';
        $this->setSeoMeta('Trang chủ - Cùng học vui', $desc);
        $this->setIndexSEO(true);

        $cates_posts = MyCache::get(config('cache_key.cates_posts'), true);

        $universities = \Cache::remember('home_universities', 60, function (){
            return University::where('is_approve', University::APPROVED)
                ->where('is_public', University::GOOGLE_INDEX)
                ->orderBy('updated_at', 'desc')->take(6)
                ->select('vi_name', 'keyword', 'phone', 'address', 'avatar', 'scale', 'description', 'slug')->get();
        });
        $news_posts = \Cache::remember('home_news_posts', 60, function (){
            return TsPost::where('is_approve', TsPost::APPROVED)
                ->where('is_public', TsPost::GOOGLE_INDEX)
                ->with(['university' => function($query){
                    $query->select('slug', 'id');
                }])
                ->orderBy('published_at', 'desc')->take(6)
                ->select('title', 'description', 'slug', 'university_id')->get();
        });

        return view('frontend.home.index', [
            'cates_posts' => $cates_posts,
            'universities' => $universities,
            'news_posts' => $news_posts
        ]);
    }
}
