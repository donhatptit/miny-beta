<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Category;
use App\Repositories\Backend\Item\CategoryRepository;
use App\Repositories\Backend\Item\PostRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Responses\Meta;
use App\Responses\ResObj;
use App\Responses\Response;

class FormulaController extends Controller
{
    protected $mobile_status = [2 ,3];

    /** @var $categoryRepository CategoryRepository */
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;

    }
    public function getCategoriesFormula(){
            $slug = 'cong-thuc';
            $cate_root = $this->categoryRepository->getCategoryBySlug($slug);
            $categories = [];
            if (!empty($cate_root)){
                $categories = array_values($cate_root->getImmediateDescendants()->whereIn('status', $this->mobile_status)->map(function ($subject) {
                    return $subject->only(['id', 'name','slug','seo_title','seo_description']);
                })->toArray());
            }
            $meta = new Meta(200);
            $response = new Response();
            $response->setValue('data', $categories);
            $resObj = new ResObj($meta, $response);
            return response()->json($resObj);
    }
}
