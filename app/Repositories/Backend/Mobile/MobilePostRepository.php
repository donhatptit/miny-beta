<?php
/**
 * Created by PhpStorm.
 * User: huyptit
 * Date: 08/08/2018
 * Time: 08:54
 */

namespace App\Repositories\Backend\Mobile;


use App\Models\Post;
use App\Repositories\BaseRepository;

class MobilePostRepository extends BaseRepository
{
    protected $mobile_status = [2 ,3];

    /**
     * @return string
     */
    public function model()
    {
        return Post::class;
    }

    public function getApprovedPostBySlug($slug,$limit = 10,$offset = 0){
        return $this->model->where('slug', 'like', "%$slug%")
            ->where('is_approve', 1)
            ->skip($offset)
            ->take($limit)
            ->whereIn('status', $this->mobile_status)
            ->get();
    }
    public function getPostAttribute($id_post, $user_id= null){
        $post = $this->getPostById( $id_post );
        $post = $post->only(['id', 'title', 'seo_title', 'slug', 'description', 'subject', 'content', 'image', 'id_next','root_cate_id']);

        if ($user_id !== null) {
            $post['saved'] = $this->model->getSavedAttribute($user_id, $post['id']);
        } else {
            $post['saved'] = false;
        }

        return $post;
    }
    public function getPostById($id){
        return Post::where('id',$id)->whereIn('status', $this->mobile_status)->first();
    }

}