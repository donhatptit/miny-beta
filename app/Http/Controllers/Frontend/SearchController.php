<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Post;
use App\Repositories\Frontend\Item\PostRepository;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;
class SearchController extends FrontendController
{
    public function __construct( PostRepository $postRepository)
    {
        parent::__construct(null, $postRepository);
    }

    public function index(Request $request){
        $query = $request->get('q');
        if($query == ""){
            return redirect('/');
        }

        SEOMeta::setTitle('Tìm kiếm - '. $query);
        $des_default_long = config('seotools.meta.defaults.description');
        SEOMeta::setDescription('Kết quả cho từ khóa : '. $query.' | cunghocvui.com - '.$des_default_long);

        $data_post = $this->postRepository->searchPostByTitle($query,20);
        $count_post = $data_post->count();


        return view('frontend.search.index',[
            'cate_posts' => $data_post,
            'count_post' => $count_post,
            'key' => $query,
        ]);
    }

    public function searchAutocomplete(Request $request){
        if ($request->ajax()){
            $key = $request->get('key');
            $arr_post = array();
            $posts = Post::where('title','LIKE',$key)->whereIn('status',[1,3])->limit(10)->select(['title', 'slug'])->get();
            if($posts->count()){
                foreach ($posts as $post){
                    $arr_post[] = [
                        $post->title,
                        $post->slug
                    ];
                }
            }
            return $arr_post;
        }
    }
}
