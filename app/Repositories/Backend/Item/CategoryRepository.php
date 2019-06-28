<?php

namespace App\Repositories\Backend\Item;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;


/**
 * Class CategoryRepository.
 */
class CategoryRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    public function getRootCategory(){
        return $this->model
            ->where('depth', 0)
            ->select(['id', 'name', 'num_approved_posts', 'num_posts'])
            ->get();
    }

    public function getParentCategory($id){
        return $this->model
                ->where('parent_id',$id)
                ->get();
    }

    public function getCategoryById($id){
        return $this->getById($id);
    }

    public function getAllCategory(){
        return $this->model->all();
    }

    public function getChildCategory($id){
        return $this->where('parent_id',$id)->get();
    }
    public function getCategoryBySlug($slug){
        return $this->where('slug',$slug)->first();
    }
}
