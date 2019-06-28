<?php
/**
 * Created by PhpStorm.
 * User: huyptit
 * Date: 08/08/2018
 * Time: 08:54
 */

namespace App\Repositories\Backend\Item;


use App\Models\Post;
use App\Repositories\BaseRepository;

class PostRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Post::class;
    }

    public function getPostsByCategory($id)
    {
        return $this->where('category_id',$id)
            ->get();
    }

    public function getApprovePost($ids = [], $cate_ids = []){
        $builder = $this->model->where('is_approve', 1);
        if($ids) $builder = $builder->whereIn('id', $ids);
        if($cate_ids) $builder = $builder->whereIn('category_id', $cate_ids);

        return $builder->get();
    }

    public function getPostAttribute($id_post,$user_id= null){
        $post = $this->getById($id_post);

        $post = $post->only(['id', 'title', 'seo_title', 'slug', 'description', 'content', 'image', 'id_next','root_cate_id']);

        if ($user_id !== null) {
            $post['saved'] = $this->model->getSavedAttribute($user_id, $post['id']);
        } else {
            $post['saved'] = false;
        }

        return $post;
    }
}