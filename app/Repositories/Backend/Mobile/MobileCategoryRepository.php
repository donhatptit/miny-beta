<?php

namespace App\Repositories\Backend\Mobile;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;


/**
 * Class MobileCategoryRepository.
 */
class MobileCategoryRepository extends BaseRepository
{
    protected $mobile_status = [2 ,3];

    /**
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    public function getMobileRootCategory( $type ){
        return $this->model->select(['id', 'name'])
            ->where('depth', 0)
            ->where('type', $type)
            ->whereIn('status', $this->mobile_status)
            ->get();
    }
    public function getCategoryById($id){
        return $this->getById($id);
    }

}
