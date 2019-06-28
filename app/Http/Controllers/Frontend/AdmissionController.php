<?php

namespace App\Http\Controllers\Frontend;

use App\Core\MyStorage;
use App\Models\Image;
use App\Models\Location;
use App\Models\Topic;
use App\Models\TsPost;
use App\Models\University;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use App\Core\Html2Text;
use Illuminate\Support\Facades\Auth;

class AdmissionController extends FrontendController
{
    public function index(){
        $seo_title = "Tổng hợp các thông tin tuyển sinh - điểm chuẩn - học phí - định hướng ngành nghề";

        $seo_description = "Thông tin tuyển sinh của các trường đại học trên cả nước. Phương thức xét tuyển, điểm chuẩn, học phí của trường. Định hướng nghề nghiệp cho các bạn học sinh, sinh viên. Click để xem ngay!";

        $this->setSeoMeta($seo_title, $seo_description);
        $this->setIndexSEO(true);
        return view('frontend.admissions.home');
    }

    public function listUniversity(Request $request){
        $district_id = $request->get('district');
        $kind = $request->get('type');
        $province_id = $request->get('province');
        $university_name = $request->get('university-name');

        $universities_builder = University::where('is_approve', University::APPROVED)
            ->where('is_public', University::GOOGLE_INDEX)
            ->select('vi_name', 'keyword', 'phone', 'address', 'avatar', 'scale', 'description', 'slug');
        if(!empty($district_id)){
            $universities_builder->where('location_id', $district_id);
        }elseif(!empty($province_id)){
                $universities_builder->where('province_id', $province_id);
        }
        if(!empty($kind)){
            $universities_builder->where('kind', $kind);
        }
        if(!empty($university_name)){
            $universities_builder->where(function($query) use($university_name){
                    $query->where('vi_name', 'LIKE', '%' . $university_name. '%')
                        ->orWhere('keyword','LIKE', '%' . $university_name. '%');
            });
        }
        $universities = $universities_builder->orderBy('updated_at', 'desc')->simplePaginate(20);

        $locations = Location::where('depth', 0)
                                ->select('name', 'id')
                                ->get();

            $seo_title = "Thông tin bạn cần biết về các trường đại học cao đẳng trên cả nước";
            $seo_description = "Thông tin bạn nên biết về các trường đại học cao đẳng trên cả nước đang chuẩn bị tuyển sinh. Cam kết cung cấp cho các bạn những thông tin đầy đủ và chính xác nhất về các trường: địa chỉ, email trường, số điện thoại trường,...";
            $this->setSeoMeta($seo_title, $seo_description);
            $this->setIndexSEO(true);
        return view('frontend.admissions.list_university', [
            'universities' => $universities,
            'locations'    => $locations
        ]);
    }

    public function searchUniversity(){
        $locations = Location::where('depth', 0)
                ->select('name', 'id')
                ->get();
        $universities = University::where('is_approve', 1)
                ->select('vi_name','slug', 'keyword')
                ->get();
        $bottom_posts = $this->getBottomPosts();

        $seo_title = "Tra cứu điểm chuẩn các trường Đại học - Cao đẳng trên cả nước chính xác nhất";
        $seo_description = "Điểm chuẩn năm 2019, 2018 chính xác nhất, liên tục cập nhật các nội dung mới của tất cả các trường trên cả nước. Tổng hợp thông tin điểm chuẩn chi tiết nhất qua từng năm. ";
        $this->setSeoMeta($seo_title, $seo_description);
        $this->setIndexSEO(true);

        return view('frontend.admissions.search_university', [
            'universities'  => $universities,
            'locations'    => $locations,
            'bottom_posts'  => $bottom_posts,
        ]);
    }
    public function listNews(){
       $universities = University::select('vi_name','slug')
           ->where('is_approve', University::APPROVED)
           ->where('is_public', University::GOOGLE_INDEX)
           ->limit(10)
           ->get();
       $posts = TsPost::where('is_approve', TsPost::APPROVED)
           ->where('is_public', TsPost::GOOGLE_INDEX)
           ->with(['university' => function($query){
               $query->select('slug', 'id');
           }])
           ->select('title', 'description', 'slug', 'university_id')
           ->orderBy('updated_at', 'desc')
           ->simplePaginate(20);

        $seo_title = "Tổng hợp những tin tức tuyển sinh mới nhất mà bạn không thể bỏ lỡ";
        $seo_description = "Tin tuyển sinh mới nhất 2019 - những điều bạn nên biết trước khi quyết định chọn trường. Tin tức tuyển sinh của tất cả các trường đại học - cao đẳng trên cả nước được chúng tôi cập nhật liên tục. ";
        $this->setSeoMeta($seo_title, $seo_description);
        $this->setIndexSEO(true);


        return view('frontend.admissions.list_news',[
            'universities'  => $universities,
            'posts'         => $posts,
        ]);
    }

    public function advice(){
        $topics_right = Topic::select('name', 'slug')
            ->has('posts')
            ->limit(10)
            ->get();
        $posts = TsPost::whereNotNull('topic_id')
            ->where('is_approve', TsPost::APPROVED)
            ->where('is_public', TsPost::GOOGLE_INDEX)
            ->select('title', 'description', 'slug', 'is_public')
            ->simplePaginate(20);
        $bottom_posts = $this->getBottomPosts();

        $seo_title = "Tổng hợp các thông tin tư vấn tuyển sinh - định hướng ngành nghề - Cunghocvui";
        $seo_description = "Rất nhiều học sinh lớp 12 còn đang băn khoăn, bỡ ngỡ không biết nên chọn theo học trường gì, chọn chuyên ngành nào. Bởi vậy, Cunghocvui chúng tôi từ những kinh nghiệm tích lũy được, đã viết ra những bài tư vấn tuyển sinh, định hướng ngành nghề chi tiết giúp các bạn có 1 quyết định chính xác nhất trước ngưỡng cửa quan trọng của cuộc đời.";
        $this->setSeoMeta($seo_title, $seo_description);
        $this->setIndexSEO(true);

        return view('frontend.admissions.advice', [
            'topics_right' => $topics_right,
            'posts'  => $posts,
            'bottom_posts'  => $bottom_posts,
        ]);

    }

    public function postDetail($slug){
        if (Auth::check()){
            $post = TsPost::where('slug', $slug)
                ->select('id', 'title','content', 'seo_title', 'seo_description','description', 'is_public', 'university_id', 'topic_id')
                ->first();
        }else{
            $post = TsPost::where('slug', $slug)
                ->where('is_approve', TsPost::APPROVED)
                ->where('is_public', TsPost::GOOGLE_INDEX)
                ->select('id', 'title','content', 'seo_title', 'seo_description', 'description', 'is_public', 'university_id', 'topic_id')
                ->first();
        }
        if (!is_object($post)){
            return redirect('404');
        }
        $arr_tags = $post->tags->pluck('name')->toArray();
        if(count($arr_tags) < 3){
            $keyword = "";
        }else{
            $keyword = $arr_tags;
        }
        $topics_right = Topic::has('posts')
            ->select('name', 'slug')
            ->limit(10)->get();
        $bottom_posts = $this->getBottomPosts();
        $this->setSeoMeta($this->buildTitle($post), $this->buildDescription($post), $keyword);
        if ($post->is_public == TsPost::GOOGLE_INDEX){
            $this->setIndexSEO(true);
        }else{

            $this->setIndexSEO(false);
        }
        return view('frontend.admissions.post_detail', [
            'post'  => $post,
            'topics_right' => $topics_right,
            'bottom_posts'  => $bottom_posts,
        ]);
    }

    public function newsTopic($slug){
        $topic = Topic::where('slug', $slug)->select('name', 'id')->first();
        $posts = TsPost::where('is_approve', TsPost::APPROVED)
            ->where('is_public', TsPost::GOOGLE_INDEX)
            ->where('topic_id', $topic->id)
            ->select('title', 'description', 'slug','is_public')
            ->simplePaginate(20);
        $topics_right = Topic::has('posts')->select('name', 'slug')
            ->limit(10)->get();

        $seo_title = "Những điều bạn nên biết về ngành " . $topic->name . " Cunghocvui";
        $seo_description = $topic->name . " là một ngành nghề đang hot hiện nay. Vậy " . $topic->name . " là gì? Học như thế nào? Hãy cùng Cunghocvui tìm hiểu xem tại sao nó lại hot như thế nhé!";
        $this->setSeoMeta($seo_title, $seo_description);
        $this->setIndexSEO(true);

        return view('frontend.admissions.news_topic',[
            'topic'  => $topic,
            'posts'         => $posts,
            'topics_right' => $topics_right,
        ]);
    }

    public function filterDistrict(Request $request){
        $province_id = $request->get('province_id');
        $districts = Location::where('parent_id', $province_id)
            ->select('name', 'id')
            ->get();
        return $districts;
    }
    public function loadMoreTopic(Request $request){
        $topics = Topic::has('posts')
            ->select('name', 'slug')
            ->offset(10)
            ->limit(100)
            ->get();
        foreach($topics as $topic){
            $topic['link'] = route('adminssion.university.topic', ['slug' => $topic['slug']]);
        }
        return $topics;
    }

    private function buildTitle($post)
    {
        if (empty($post->seo_title)) {
            return $post->title;
        } else {
            return $post->seo_title;
        }

    }
    private function buildDescription($post){
        if(empty($post->seo_description)){
            if(!empty($post->description)){
                return $post->description;
            }else{
                $html_to_text = new Html2Text($post->content);
                $content_text = $html_to_text->getPlainText();
                $content_text = str_replace(["\"", "\'", "(", ")", "*", "-", "_"], "", $content_text);
                if (strlen($content_text) > 300){
                    $desc = mb_substr($content_text,0, 300);
                }else{
                    $desc = $content_text;
                }
                $desc = str_replace(["\"", "\'", "(", ")", "*", "-", "_"], "", $desc);
                return $desc;
            }
        }else {
            return $post->seo_description;
        }
    }

    public function getBottomPosts(){
        $bottom_posts = TsPost::whereNotNull('university_id')
            ->where('is_approve', TsPost::APPROVED)
            ->where('is_public', TsPost::GOOGLE_INDEX)
            ->with(['university' => function($query){
                $query->select('slug', 'id');
            }])
            ->select('title', 'description', 'slug', 'university_id','is_public', 'is_approve')
            ->limit(6)
            ->get();
        return $bottom_posts;
    }

}
