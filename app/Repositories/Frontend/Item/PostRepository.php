<?php
/**
 * Created by PhpStorm.
 * User: huyptit
 * Date: 08/08/2018
 * Time: 09:43
 */

namespace App\Repositories\Frontend\Item;


use App\Models\Post;
use App\Repositories\BaseRepository;

class PostRepository extends BaseRepository
{
    protected $web_status = [1 ,3];

    public function model()
    {
        return Post::class;
    }

    public function findPostBySlug($slug){
        return $this->model->with(['category' => function($query) {
                        $query->select(['id', 'name', 'slug']);
                    },'post_answer'])
                    ->where('slug', $slug)->select('id', 'category_id', 'slug', 'title', 'subject', 'content', 'seo_title', 'is_public', 'is_approve','seo_description')
                    ->first();

    }

    public function getApprovedPost(){
        return $this->where('is_approve', Post::APPROVED);
    }

    public function findPostApproveBySlug($slug){
        return $this->model->with('post_answer:post_id,content')
            ->where('is_approve', Post::APPROVED)
            ->where('slug', $slug)
            ->select('id', 'category_id', 'slug', 'title', 'subject', 'content', 'seo_title', 'is_public', 'is_approve','seo_description', 'description', 'count_word')
            ->first();
    }

    public function findPostsByIdCategory($id, $limit, $orderBy = 'desc', $id_current_post = null){
        $post = $this->getApprovedPost()
                ->where('category_id', $id)
                ->orderBy('updated_at', $orderBy)
                ->limit($limit);

        if(!is_null($id_current_post)) $post->where('id', $id_current_post,"<>");

        return $post;
    }

    public function findPostBetweenId($id_start, $id_end, $limit, $id_current_post = null){
        $post = $this->getApprovedPost()
                    ->whereBetween('id', [$id_start, $id_end])
                    ->limit($limit);

        if(!is_null($id_current_post)) $post->where('id', $id_current_post, "<>");

        return $post;
    }

    public function searchPostByTitle($query, $limit = 0){
        $post =  $this->model
                    ->search($query)
                    ->where('is_approve', Post::APPROVED);

        return $limit == 0 ? $post->get()->whereIn('status', $this->web_status) : $post->take($limit)->get()->whereIn('status', $this->web_status);
    }

    public function searchPostByTitlePaginate($query,$paginate = ''){
        return $this->model
                    ->where('title','LIKE','%'.$query.'%')
                    ->where('is_approve', Post::APPROVED)
                    ->whereIn('status',[1,3])
                    ->simplePaginate($paginate);
    }
    public function getAllPostByIdCategory($id_category, $paginate = '',$oderBy = 'title'){
        $post_builder = $this->model->with('kinds')->where('category_id', $id_category)->where('is_approve', Post::APPROVED)->select('id', 'category_id', 'slug', 'title', 'subject', 'content', 'seo_title', 'is_public', 'is_approve', 'seo_description','description','count_word')->orderBy($oderBy);
            if($paginate == ''){
                $posts = $post_builder->get();
            }else{
                $posts = $post_builder->simplePaginate($paginate);
            }
        return $posts;

    }






}