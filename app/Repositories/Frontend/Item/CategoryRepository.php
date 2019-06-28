<?php
/**
 * Created by PhpStorm.
 * User: huyptit
 * Date: 08/08/2018
 * Time: 09:14
 */

namespace App\Repositories\Frontend\Item;


use App\Models\Category;
use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository
{
    protected $web_status = [1 ,3];

    public function model()
    {
       return Category::class;
    }

    public function findCategoryBySlug($slug){
        return $this->model->with(['children' => function($query) {
                $query->whereIn('status', $this->web_status )->select(['id', 'name', 'slug', 'lft', 'rgt', 'parent_id', 'num_approved_posts']);
            }])
            ->with('parent:id,name')
            ->where('slug', $slug)
            ->whereIn('status', $this->web_status )
            ->select(['id', 'name', 'lft', 'rgt', 'parent_id', 'depth', 'seo_title', 'seo_description', 'num_approved_posts', 'slug', 'description_bottom', 'description_top'])
            ->first();
    }

    public function getCacheParentCategory($limit = 10){
        return $this->model->with(['children' => function($query) {
                $query->select(['id', 'name', 'lft', 'rgt', 'parent_id', 'slug']);
            }])
            ->where('depth', 0)
            ->limit($limit)
            ->select(['id', 'name', 'lft', 'rgt', 'parent_id', 'slug'])
            ->get();
    }

    public function getCacheHomeCategory(){
        return $this->with(['children'])
            ->where('depth', 0)
            ->get();
    }
}