<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Repositories\Backend\Mobile\MobilePostRepository;
use App\Responses\Meta;
use App\Responses\ResObj;
use App\Responses\Response;
use App\SearchHistory;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * @var $postRepository
     */
    protected $postRepository;

    /**
     * ProfileController constructor.
     *
     * @param MobilePostRepository $postRepository
     */
    public function __construct(MobilePostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getPost(Request $request){
        $id = $request->get('id');
        try{
            $post = $this->postRepository->getPostById($id);
        }catch (\Exception $e){
            $meta = new Meta(400, $e->getMessage());
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        if(!$post || $post->is_approve != 1) {
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        $auth_key = $request->header('authorization');
        $user = User::getUserFromAuthKey($auth_key);
        if(!$user){
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        $post = $this->postRepository->getPostAttribute($post->id, $user->id);

        $meta = new Meta(200);
        $response = new Response();
        $response->setValue('data', $post);
        $resObj = new ResObj($meta, $response);

        return response()->json($resObj);
    }

    public function findPost(Request $request){
        $key = $request->get('key');
        $limit = $request->get('limit',5);
        $offset = $request->get('offset',0);
        if(!$key){
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }
        $posts = $this->postRepository->getApprovedPostBySlug($key,$limit,$offset)->map(function ($subject) {
            return $this->postRepository->getPostAttribute($subject->id);
        });

        $auth_key = $request->header('authorization');
        $user = User::getUserFromAuthKey($auth_key);
        if(!$user){
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        $exist = SearchHistory::where('user_id', $user->id)->where('keyword', $key)->first();

        if($exist){
            $exist->touch();
        }else{
            $now = Carbon::now();

            SearchHistory::create([
                'user_id' => $user->id,
                'keyword' => $key,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $meta = new Meta(200);
        $response = new Response();
        $response->setValue('data', $posts);
        $resObj = new ResObj($meta, $response);

        return response()->json($resObj);
    }

    public function upload_post(Request $request){
        $auth_key = $request->header('authorization');
        $user = User::getUserFromAuthKey($auth_key);
        if(!$user){
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        $title = $request->get('title');
        $subject = $request->get('subject');
        $content = $request->get('content');
        $category_id = $request->get('category_id');

        $saved = Post::create([
            'title' => $title,
            'subject' => $subject,
            'content' => $content,
            'category_id' => $category_id,
            'created_by' => $user->id,
            'status' => Post::DISPLAY_MOBILE,
            'is_approve' => Post::APPROVED
        ]);

        if($saved){
            $meta = new Meta(200);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        $meta = new Meta(400);
        $response = new Response();
        $resObj = new ResObj($meta, $response);

        return response()->json($resObj);
    }
    public function update_upload_post(Request $request){
        $auth_key = $request->header('authorization');
        $user = User::getUserFromAuthKey($auth_key);
        if(!$user){
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        $title = $request->get('title');
        $subject = $request->get('subject');
        $content = $request->get('content');
        $category_id = $request->get('category_id');
        $post = Post::where('title',$title)->where('category_id',$category_id)->first();
        if($post){
            $post->content = $content;
            $post->subject = $subject;
            $post->save();

            $meta = new Meta(200);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);

        }
        $meta = new Meta(400);
        $response = new Response();
        $resObj = new ResObj($meta, $response);

        return response()->json($resObj);

    }
}
