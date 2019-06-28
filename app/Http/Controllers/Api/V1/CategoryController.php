<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Category;
use App\Models\Post;
use App\Repositories\Backend\Mobile\MobilePostRepository;
use App\Repositories\Backend\Mobile\MobileCategoryRepository;
use App\Responses\Meta;
use App\Responses\ResObj;
use App\Responses\Response;
use App\User;
use Baum\Node;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    protected $mobile_status = [2 ,3];

    /**
     * @var MobileCategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var MobilePostRepository
     */
    protected  $postRepository;

    /**
     * ProfileController constructor.
     *
     * @param MobileCategoryRepository $categoryRepository
     * @param MobilePostRepository $postRepository
     *
     */
    public function __construct(MobileCategoryRepository $categoryRepository, MobilePostRepository $postRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->postRepository = $postRepository;
    }

    public function getClass(Request $request){
        $type = $request->get('type');
        $all_class = $this->categoryRepository->getMobileRootCategory( $type )->toArray();

        $meta = new Meta(200);
        $response = new Response();
        $response->setValue('data', $all_class);
        $resObj = new ResObj($meta, $response);

        return response()->json($resObj);
    }

    public function getSubject(Request $request){
        $class_id = $request->get('class_id');
        try{
            $class = $this->categoryRepository->getById($class_id);
        }catch (\Exception $e){
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        if(!$class || $class->depth != 0) {
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        if($class->type && $class->type != 'class') {
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        /** @var $class Node */
        $subjects = array_values($class->getImmediateDescendants()->whereIn('status', $this->mobile_status)->map(function ($subject) {
            return $subject->only(['id', 'name', 'slug', 'seo_title', 'seo_description']);
        })->toArray());

        $meta = new Meta(200);
        $response = new Response();
        $response->setValue('data', $subjects);
        $resObj = new ResObj($meta, $response);

        return response()->json($resObj);
    }

    public function getLesson(Request $request){
        $subject_id = $request->get('subject_id');
        $limit = $request->get('limit', 10);
        $offset = $request->get('offset', 0);

        try{
            $subject = $this->categoryRepository->getById($subject_id);
        }catch (\Exception $e){
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        if(!$subject || $subject->depth != 1) {
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        if($subject->type && $subject->type != 'subject') {
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        /** @var $subject Node */
        $response = $this->getDescendants($subject, $limit, $offset);
        $meta = new Meta(200);

        $resObj = new ResObj($meta, $response);

        return response()->json($resObj);
    }

    public function getDescendants( Node $category, $limit = 10, $offset = 0, $level = 1){
        $response = new Response();

        if($level <= 2) $response->setValue("section_lv$level", $category->only(['id', 'name', 'slug', 'seo_title', 'seo_description']));
        else{
            $response->setValue('id', $category->id);
            $response->setValue('name', $category->name);
        }

        $cate_children = $category->getImmediateDescendants()->whereIn('status', $this->mobile_status);

        $data = new Collection();

        //đánh dấu node chứa các category nhỏ nhất
        $is_leaf = false;

        foreach($cate_children as $cate_child){
            $res = $this->getDescendants($cate_child, $limit, $offset,$level + 1);

            if(!$is_leaf){
                $data_property = $this->getDataProperty($level + 1);
                if($res->$data_property->count() === 0) {
                    $is_leaf = true;
                }
            }

            if($res) $data->add($res);
        }

        if($is_leaf) $data = $data->filter(function ($value, $key) use($offset, $limit){
            return $key >= $offset && $key < $offset + $limit;
        });;

        $data_property = $this->getDataProperty($level);
        $response->setValue($data_property, $data);

        return $response;
    }

    public function getDataProperty($level){
        if($level <= 2) return "items";
        return "data";
    }

    public function getPost(Request $request){
        $id_cate = $request->get('id_cate');
        try{
            $category = $this->categoryRepository->getById($id_cate);
        }catch (\Exception $e){
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        if(!$category) {
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
        /** @var $category Node */
        /** @var $posts Collection*/

        $posts = $category->posts->whereIn('status', $this->mobile_status)->where('is_approve', 1)->map(function ($subject) use($user){
            $subject = $this->postRepository->getPostAttribute($subject->id, $user->id);
            return $subject;
        });

        $meta = new Meta(200);
        $response = new Response();
        $data = [];
        foreach ($posts as $post){
            $data[] = $post;
        }
        $response->setValue('data', $data);
        $resObj = new ResObj($meta, $response);

        return response()->json($resObj);
    }


    //form data
    public function find_category(Request $request){
        $data = $request->get('data');

        $category_id = $this->detectCategory(null, $data);
        if($category_id) {
            $meta = new Meta(200);
            $response = new Response();
            $response->setValue('data', $category_id);
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        $meta = new Meta(400);
        $response = new Response();
        $resObj = new ResObj($meta, $response);

        return response()->json($resObj);
    }

    public function detectCategory( Node $category = null, $data){
        if($category && $category->isLeaf()) return $category->id;

        if($category) $cate_children = $category->getImmediateDescendants();
        else $cate_children = Category::where('depth', 0)->where('slug', 'like', 'lop-%')->get();

        $max_score = 0;
        $best_child = null;

        foreach($cate_children as $cate_child){
            $score = $this->calScore($cate_child, $data);

            if($score > $max_score){
                $max_score = $score;
                $best_child = $cate_child;
            }
        }
        if($max_score == 0) return null;

        return $this->detectCategory($best_child, $data);
    }

    public function calScore(Node $category, $data){
        $cate_name = $category->name;

        $score = 0;

        foreach($data as $d){
            $score += $this->stringIntersect($cate_name, $d);
        }

        return $score;
    }

    public function stringIntersect($string1, $string2){
        $string1 = $this->standardString($string1);
        $string2 = $this->standardString($string2);

        if($string1 === $string2) return 9999;

        $words1 = explode(' ', $string1);
        $words2 = explode(' ', $string2);

        $intersect = array_intersect($words1, $words2);
        $str_intersect = implode(' ', $intersect);

        $score = ($str_intersect == $string1) ? 9999 : count($intersect);

        return $score;
    }

    public function standardString($string){
        $string = mb_strtolower($string);
        $string = trim($string);

        return $string;
    }
    public function relatedPost(Request $request)
    {
        $auth_key = $request->header('authorization');
        $user = User::getUserFromAuthKey($auth_key);
        if (!$user) {
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }
        $id_category = $request->get('id');
        $current_cate = $this->categoryRepository->getCategoryById($id_category);
        if (!$current_cate) {
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);
            return response()->json($resObj);
        } else {
            /** @var $category Node */
            $post = $this->getPostFromIdCate($id_category,10);
            $posts = $post->map(function ($subject) use ($user) {
                $subject = $this->postRepository->getPostAttribute($subject->id, $user->id);
                return $subject;
            });
            $meta = new Meta(200);
            $response = new Response();
            $response->setValue('data', $posts);
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);

        }
    }
    public function getPostFromIdCate($id_cate,$limit){
        $category = $this->categoryRepository->getCategoryById($id_cate);
        $cate_leaves = $category->getLeaves(['id']);
        $posts = Post::whereIn('category_id',$cate_leaves)
                        ->whereIn('status', $this->mobile_status)
                        ->where('is_approve', Post::APPROVED)
                        ->limit($limit)
                        ->get();
        if(count($posts) < 1 ){
            $parent = $category->parent;
             return $this->getPostFromIdCate($parent->id, $limit);
        }
        return $posts;
    }
}
