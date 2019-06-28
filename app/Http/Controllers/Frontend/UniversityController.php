<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Image;
use App\Models\Location;
use App\Models\Score;
use App\Models\TsPost;
use App\Models\University;
use App\Models\UniversityAttribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Core\Html2Text;

class UniversityController extends FrontendController
{
    public function index($slug){
        if (Auth::check()) {
            $university = University::where('slug', $slug)
                ->first(['id', 'vi_name', 'avatar', 'keyword', 'en_name', 'slug', 'code', 'address', 'phone', 'established', 'type', 'organization', 'scale', 'website', 'google_map']);
        }else{
            $university = University::where('slug', $slug)
                ->where('is_approve', University::APPROVED)
                ->where('is_public', University::GOOGLE_INDEX)
                ->first(['id', 'vi_name', 'avatar', 'keyword', 'en_name', 'slug', 'code', 'address', 'phone', 'established', 'type', 'organization', 'scale', 'website', 'google_map']);
        }
        if(!is_object($university)){
            return redirect('404');
        }
        $locations = Location::where('depth', 0)
                    ->select('name', 'id')
                    ->get();
        $images = Image::where('university_id', $university->id)
                ->limit(3)
                ->select('path', 'title')
                ->get();

        if (Auth::check()) {
            $post = UniversityAttribute::where('university_id', $university->id)
                ->where('type', UniversityAttribute::XET_TUYEN)
                ->orderBy('year', 'desc')
                ->first(['id', 'year', 'title', 'seo_title', 'seo_description', 'content', 'is_public', 'is_approve']);
        }else{
            $post = UniversityAttribute::where('university_id', $university->id)
                ->where('type', UniversityAttribute::XET_TUYEN)
                ->where('is_public', UniversityAttribute::GOOGLE_INDEX)
                ->where('is_approve', UniversityAttribute::APPROVED)
                ->orderBy('year', 'desc')
                ->first(['id', 'year', 'title', 'seo_title', 'seo_description', 'content', 'is_public', 'is_approve']);
        }
        if($post){
            $this->setSeoMeta($this->buildTitle($post), $this->buildDescription($post));
            $this->setIndexSEO(true);
        }
        $bottom_posts = $this->getBottomPosts();



        return view('frontend.admissions.university.detail', [
            'university' => $university,
            'images'    => $images,
            'locations'    => $locations,
            'bottom_posts'  => $bottom_posts,
            'post'   => $post,
        ]);
    }

    public function score(Request $request, $slug){
        $university = University::where('slug', $slug)
            ->where('is_approve', University::APPROVED)
            ->where('is_public', University::GOOGLE_INDEX)
            ->first(['id', 'vi_name', 'avatar', 'keyword', 'en_name', 'slug', 'code', 'address', 'phone', 'established', 'type', 'organization', 'scale', 'website', 'google_map']);
        if(!is_object($university)){
            return redirect('404');
        }
        $locations = Location::where('depth', 0)
                    ->select('name', 'id')
                    ->get();
        $images = Image::where('university_id', $university->id)
                ->limit(3)
                ->select('path', 'title')
                ->get();
        $bottom_posts = $this->getBottomPosts();

        $year_current = $request->get('y');
        $year_default = UniversityAttribute::where('university_id', $university->id)
                        ->where('type', UniversityAttribute::DIEM_CHUAN)
                        ->max('year');
        if(empty($year_current)){
            $year_current = $year_default;
        }
        if (Auth::check()) {
            $years = UniversityAttribute::where('university_id', $university->id)
                ->where('type', UniversityAttribute::DIEM_CHUAN)
                ->groupBy('year')
                ->pluck('year');
            $score = UniversityAttribute::where('year', $year_current)
                ->where('university_id', $university->id)
                ->where('type', UniversityAttribute::DIEM_CHUAN)
                ->first();
        }else{
            $years = UniversityAttribute::where('university_id', $university->id)
                ->where('type', UniversityAttribute::DIEM_CHUAN)
                ->where('is_approve', UniversityAttribute::APPROVED)
                ->groupBy('year')
                ->pluck('year');
            $score = UniversityAttribute::where('year', $year_current)
                ->where('university_id', $university->id)
                ->where('type', UniversityAttribute::DIEM_CHUAN)
                ->where('is_approve', UniversityAttribute::APPROVED)
                ->where('is_public', UniversityAttribute::GOOGLE_INDEX)
                ->first();
        }
        $seo_title = "Điểm chuẩn " . $university->vi_name . " 2019 chính xác nhất";
        $seo_description = "Tra cứu điểm chuẩn trường" . $university->vi_name . " 2019 chính xác và đầy đủ nhất. Xem điểm chuẩn các ngành trường" . $university->vi_name . " 2019";
        $this->setSeoMeta($seo_title, $seo_description);
        $this->setIndexSEO(true);


        return view('frontend.admissions.university.score', [
            'university' => $university,
            'images'    => $images,
            'locations'    => $locations,
            'bottom_posts' => $bottom_posts,
            'score'       => $score,
            'year'         => $year_current,
            'years'         => $years
        ]);
    }
    public function news($slug){
        $university = University::where('slug', $slug)
            ->where('is_approve', University::APPROVED)
            ->where('is_public', University::GOOGLE_INDEX)
            ->first(['id', 'vi_name', 'avatar', 'keyword', 'en_name', 'slug', 'code', 'address', 'phone', 'established', 'type', 'organization', 'scale', 'website', 'google_map']);
        if(!is_object($university)){
            return redirect('404');
        }
        $posts = TsPost::where('university_id', $university->id)
                ->where('is_approve', TsPost:: APPROVED)
                ->where('is_public', TsPost::GOOGLE_INDEX)
                ->with(['university' => function($query){
                    $query->select('slug', 'id');
                }])
                ->select('title', 'description', 'slug', 'university_id')
                ->simplePaginate(10);
        $locations = Location::where('depth', 0)
                    ->select('name', 'id')
                    ->get();
        $images = Image::where('university_id', $university->id)
                ->limit(3)
                ->select('path', 'title')
                ->get();
        $bottom_posts = $this->getBottomPosts();

        $seo_title = "Tin tức tuyển sinh của trường " . $university->vi_name . " không thể bỏ qua";
        $seo_description = "Thông báo, tin tức tuyển sinh của trường " . $university->vi_name . " cập nhật mới nhất. Hãy theo dõi ngay để không bỏ lỡ những thông tin quan trọng.";
        $this->setSeoMeta($seo_title, $seo_description);
        $this->setIndexSEO(true);

        return view('frontend.admissions.university.news', [
            'university' => $university,
            'images'    => $images,
            'locations'    => $locations,
            'bottom_posts'  => $bottom_posts,
            'posts'     => $posts,
        ]);
    }
    public function showImage($slug){
        $university = University::where('slug', $slug)
            ->where('is_approve', University::APPROVED)
            ->where('is_public', University::GOOGLE_INDEX)
            ->first(['id', 'vi_name', 'avatar', 'keyword', 'en_name', 'slug', 'code', 'address', 'phone', 'established', 'type', 'organization', 'scale', 'website', 'google_map']);
        if(!is_object($university)){
            return redirect('404');
        }
        $locations = Location::where('depth', 0)
                    ->select('name', 'id')
                    ->get();
        $images = Image::where('university_id', $university->id)
                    ->limit(10)
                    ->select('path','title')
                    ->get();
        $bottom_posts = $this->getBottomPosts();

        $seo_title = "Những hình ảnh đẹp nhất về trường " . $university->vi_name . " Cunghocvui";
        $seo_description = "Cập nhật các hình ảnh đẹp nhất về trường " . $university->vi_name . " Cùng khám phá ngay với chúng tôi nhé!";
        $this->setSeoMeta($seo_title, $seo_description);
        $this->setIndexSEO(true);

        return view('frontend.admissions.university.show_image', [
            'university' => $university,
            'locations'    => $locations,
            'bottom_posts'  => $bottom_posts,
            'images' => $images,
        ]);
    }
    public function getBottomPosts(){
        $bottom_posts = TsPost::whereNotNull('topic_id')
            ->where('is_approve', TsPost::APPROVED)
            ->where('is_public', TsPost::GOOGLE_INDEX)
            ->select('title', 'description', 'slug', 'is_public', 'is_approve')
            ->limit(6)
            ->get();
        return $bottom_posts;
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
        if(strlen($post->seo_description) < 160){
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
        }else {
            return $post->seo_description;
        }
    }
    public function storeStatusPost(Request $request){
        $status = $request->get('status');
        $id_post = $request->get('id_post');
        try{
            $post = UniversityAttribute::find($id_post);
            if($status == 1){
                $post->is_approve = UniversityAttribute::APPROVED;
                $post->is_public = UniversityAttribute::GOOGLE_INDEX;


            }else{
                $post->is_approve = UniversityAttribute::NOT_APPROVE;
                $post->is_public = UniversityAttribute::GOOGLE_NOINDEX;
            }
            $post->save();
        }catch (\Exception $e){
            return redirect()->back();
        }
        return redirect()->back();

    }
}
