<?php
/**
 * Created by PhpStorm.
 * User: conghoan
 * Date: 5/29/18
 * Time: 16:37
 */

namespace App\Http\Controllers\Frontend;


use App\Models\Post;
use App\Repositories\Frontend\Item\PostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Core\Html2Text;


class PostController extends FrontendController
{
    public function __construct( PostRepository $postRepository)
    {
        parent::__construct(null,$postRepository);

    }

    public function detail(Request $request, $slug)
    {
        if (Auth::check()){
            $post        = $this->postRepository->findPostBySlug($slug);
        }else{
            $post        = $this->postRepository->findPostApproveBySlug($slug);
        }
        if (!is_object($post)){
            return redirect('404');
        }
        $category = $post->category()->first();
        if($category){
            $category_subject = $category->getCategorySubject();
        }else{
            $category_subject = null;
        }
        if(!empty($category_subject)){
            if(preg_match('/^ngu-van/', $category_subject->slug, $arr_subject)){
                $subject = 'ngu-van';
            }else{
                $subject = 'other';
            }
        }else{
            $subject = 'other';
        }

        $right_posts = $this->postRepository->findPostsByIdCategory($post->category_id,11,'desc', $post->id)->get(['slug', 'title', 'is_public']);
        $post_start  = $post->id - 4;
        $post_end    = $post->id + 4;
        if ($post_start < 0) {
            $post_start = 0;
            $post_end   = $post->id + 8;
        }
        $bottom_posts = $this->postRepository->findPostBetweenId($post_start,$post_end,8,$post->id)->get(['slug', 'title', 'content','is_public']);
        if(!empty($category_subject)){
            $categories_sidebar = $category_subject->getDescendantsAndSelf(['slug', 'name','depth']);
        }else{
            $categories_sidebar = null;
        }

        $data         = [
            'post'         => $post,
            'right_posts'  => $right_posts,
            'bottom_posts' => $bottom_posts,
            'subject'      => $subject,
            'category' => $category,
            'category_subject' => $category_subject,
            'categories_sidebar' => $categories_sidebar,
        ];
        $this->setSeoMeta($this->buildTitle($post), $this->buildDescription($post));
        if ($post->is_public == Post::GOOGLE_INDEX){
            $this->setIndexSEO(true);
        }else{

            $this->setIndexSEO(false);
        }

        return view('frontend.posts.detail', $data);
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
    public function storeStatus(Request $request)
    {
        $res['success']= false;
        if (Auth::check()) {
            $user = Auth::user();
            $role = $user->isAdmin();
            // kiem tra co phai quyen admin khong
            if ($role) {
                if ($request->ajax()) {
                    try {
                        $post = Post::find($request->id_post);
                        if (!$post) {
                            abort(404);
                        }
                        $post->is_public = $request->is_public;
                        $post->is_approve = $request->is_approve;
                        if ($request->is_approve == 1) {
                            $post->approved_at = Carbon::now();
                        }

                        $check = $post->save();
                        if($check){
                            $res['success']= true;
                        }
                        return $res;

                    } catch (\Exception $e) {
                        return $res;
                    }
                }
                if ($request->action == -1) {
                    try {

                        $post = Post::find($request->id_post);
                        $post->is_approve = -1;
                        $post->unapprove_reason = $request->reason;
                        $post->save();

                    } catch (\Exception $e) {
                        \Log::error('PostController@storeStatus : ' . $e->getMessage());
                    }
                }
            }
        }
        return back();
    }
}