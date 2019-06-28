<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Item\CategoryRepository;
use App\Repositories\Backend\Item\PostRepository;
use App\Responses\Meta;
use App\Responses\ResObj;
use App\Responses\Response;
use App\User;
use Baum\Node;
use Illuminate\Http\Request;

class OfflineController extends Controller
{
    /**
     * @var PostRepository
     */
    protected $postRepository;
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * ProfileController constructor.
     *
     * @param PostRepository $postRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(PostRepository $postRepository, CategoryRepository $categoryRepository)
    {
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function postOffline(Request $request){
        $auth_key = $request->header('authorization');
        $user = User::getUserFromAuthKey($auth_key);
        if(!$user){
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        $post_id = $request->get('post_id');

        try{
            \DB::table('user_offline')->insert([
                'user_id' => $user->id,
                'target_id' => $post_id,
                'type' => 'post',
            ]);

            $meta = new Meta(200);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }catch (\Exception $e){
            $meta = new Meta(400, $e->getMessage());
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }
    }

    public function getOfflinePost(Request $request){
        $auth_key = $request->header('authorization');
        $user = User::getUserFromAuthKey($auth_key);
        if(!$user){
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        $user_offlines = \DB::table('user_offline')
            ->where('user_id', $user->id)
            ->get();

        if( count( $user_offlines ) < 1 ){

            $meta = new Meta(200);
            $response = new Response();
            $response->setValue('data', []);
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        $offline_post_ids = [];
        foreach($user_offlines as $user_offline){
            $offline_post_ids[] = $user_offline->target_id;
        }

        $descendant_ids = [];
        if($cate_id = $request->get('id_category')) $descendant_ids = $this->getAllDescendantsId($cate_id);

        $offline_posts = $this->postRepository->getApprovePost($offline_post_ids, $descendant_ids)->map(function ($subject) use($user) {
            return $this->postRepository->getPostAttribute($subject->id, $user->id);

        });

        $meta = new Meta(200);
        $response = new Response();
        $response->setValue('data', $offline_posts);
        $resObj = new ResObj($meta, $response);

        return response()->json($resObj);
    }

    public function getAllDescendantsId($cate_id){
        $root_cate = $this->categoryRepository->getById($cate_id);
        if(!$root_cate) return [$cate_id];

        /** @var $root_cate Node*/
        $descendants = $root_cate->getDescendantsAndSelf()->toArray();
        $descendant_ids = [];
        foreach ($descendants as $descendant){
            $descendant_ids[] = $descendant['id'];
        }

        return $descendant_ids;
    }

    public function deleteOffline($id){
        try{
            \DB::table('user_offline')
                ->where('id', $id)
                ->delete();

            $meta = new Meta(200);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }catch (\Exception $e){
            $meta = new Meta(400, $e->getMessage());
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }
    }
}
