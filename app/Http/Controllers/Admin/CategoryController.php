<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Repositories\Backend\Item\CategoryRepository;
use App\Repositories\Backend\Item\PostRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;
    /** @var PostRepository*/
    protected $postRepository;

    const LIST_INDENT = "=== ";
    /**
     * ProfileController constructor.
     *
     * @param CategoryRepository $categoryRepository
     * @param PostRepository $postRepository
     */
    public function __construct(CategoryRepository $categoryRepository, PostRepository $postRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->postRepository = $postRepository;
    }

    public function index(Request $request){

        // phần lọc danh mục theo danh muc goc :
        $cate_root = $this->categoryRepository->getRootCategory();
        $parent_id = null;
        if($request->ajax()){
            $id_cate = $request->get('id_cate');
            $category = $this->categoryRepository->getParentCategory($id_cate);
            return response($category);
        }
        // het phan loc danh muc

        $name_cate_one = '';
        if($request->category_root){
           $parent_id = $request->category_root;
           if($request->category_one){
               $parent_id = $request->category_one;
               $name_cate_one = $request->category_one;

           }
       }
        $display_category = $request->get('display_category');

        if(isset($parent_id) && $parent_id !=''){
            $tree_category = $this->categoryRepository->getCategoryById($parent_id)->getDescendantsAndSelf();
        }else{
            $tree_category = $this->categoryRepository->getAllCategory();
        }

        if($display_category !== null){
            $tree_category = $tree_category->where('status',$display_category);
        }

        // page hiện tại
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Tao collection tu mang
        $itemCollection = collect($tree_category);

        // so danh muc tren 1 trang
        $perPage = config('view.item_page');

        // lấy danh sách danh mục cho trang hiện tại
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        // tao thanh paginate
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);

        // Tạo link
        $paginatedItems->setPath($request->url());


        return view('vendor.backpack.base.categories',[
            'tree_category' => $paginatedItems,
            'cate_root' => $cate_root,
            'category_root' => $request->category_root,
            'category_one' => $request->category_one,
            'name_cate_one' => $name_cate_one,
            'display_category'=>$display_category
        ]);

    }
    public function checkMoving($id, $direction){
        $result = [
            'move_title'=>'Di chuyển',
            'success' => false,
            'movable' => false,
            'message' => 'Unknown error!!!'
        ];
        $category = $this->categoryRepository->getCategoryById($id);

        if(!$category){
            abort(404);
        }
        switch($direction){
            case 'up':
                if($sibling = $category->getLeftSibling()){
                    $result['success'] = true;
                    $result['movable'] = true;
                    $result['message'] = "Danh mục <b>".$category->name."</b> sẽ xếp trên danh mục <b>".$sibling->name."</b>";
                }else{
                    $result['move_title'] = 'Không thể di chuyển';
                    $result['message'] = "Danh mục <b>".$category->name."</b> không thể di chuyển lên trên";
                }
                break;
            case 'right':
                if($sibling = $category->getLeftSibling()){
                    $result['success'] = true;
                    $result['movable'] = true;
                    $result['message'] = "Danh mục <b>".$category->name."</b> sẽ thành con của danh mục <b>".$sibling->name."</b>";
                }else{
                    $result['move_title'] = 'Không thể di chuyển';
                    $result['message'] = "Danh mục <b>".$category->name."</b>b> không thể di chuyển sang phải";
                }
                break;
            case 'down':
                if($sibling = $category->getRightSibling()){
                    $result['success'] = true;
                    $result['movable'] = true;
                    $result['message'] = "Danh mục <b>".$category->name."</b> sẽ xếp dưới <b>".$sibling->name."</b>";
                }else{
                    $result['move_title'] = 'Không thể di chuyển';
                    $result['message'] = "Danh mục <b>".$category->name."</b> không thể di chuyển xuống dưới";
                }
                break;
            case 'left':
                if($parent = $category->parent){
                    $result['success'] = true;
                    $result['movable'] = true;
                    $result['message'] = "Danh mục <b>".$category->name."</b> ngang bằng với danh mục <b>".$parent->name."</b>";
                }else{
                    $result['move_title'] = 'Không thể di chuyển';
                    $result['message'] = "Danh mục <b>".$category->name."</b> không thể di chuyển sang trái";
                }
                break;
            default:
                abort(404);
        }
        if($result['movable'] == true){
            $result['move_link'] = route('backend.category.moving', ['id' => $id, 'direction' => $direction]);
        }
        return json_encode($result);
    }
    public function moving($id,$direction){

        $result = [
            'success' => false,
            'moved' => false,
            'message' => 'Unknown error!!!'];
        $cate =$this->categoryRepository->getCategoryById($id);
        $children = $cate->descendantsAndSelf()->get(['id']);
        $remove = [];
        foreach($children as $v){
            $remove[] = $v->id;
        }
        switch($direction){
            case 'left' :
                if($parent = $cate->parent){
                    $cate->makeSiblingOf($parent);
                    $result['success'] = true;
                    $result['moved'] = true;
                }else{
                    $result['message'] = 'Can\'t move';
                }
                break;
            case 'up':
                if($sibling = $cate->getLeftSibling()){
                    $cate->moveLeft();
                    $result['success'] = true;
                    $result['moved'] = true;
                }else{
                    $result['message'] ='err';
                }
                break;
            case 'right':
                if($sibling = $cate->getLeftSibling()){
                    $cate->makeLastChildOf($sibling);
                    $result['success'] = true;
                    $result['moved'] = true;
                }else{
                    $result['message'] = 'err';
                }
                break;
            case 'down':
                if($sibling = $cate->getRightSibling()){
                    $cate->moveRight();
                    $result['success'] = true;
                    $result['moved'] = true;
                }else{
                    $result['message'] = 'err';
                }
                break;
            default:
                abort(404);

        }
        if($result['moved']){
            $result['message'] = "Di chuyển hành công danh mục <b>".$cate->name."</b>";
        }
        return $result;
    }
    public function delete($id){
        $result = [
            'title'=>'Thất bại',
          'message'=> 'Có lỗi xảy ra, thử lại..'
        ];
        $category = $this->categoryRepository->getCategoryById($id);
        $count_post =$this->postRepository->getPostsByCategory($id)->count();
        if ($this->categoryRepository->getChildCategory($id)->count() > 0 || $count_post > 0 ){
           $result['message'] = 'Bạn phải xóa danh mục con và bài viết trong danh mục <b>'.$category->name."</b> trước";

        }else{
           $category->delete();
           $result['title'] = 'Thành công';
            $result['message'] = "Xóa thành công danh mục <b>".$category->name."</b>";
        }

        return $result;
    }

    public function getCategory(Request $request){
        $id_category = $request->get('id_category');
        $parent_cate = Category::find($id_category);
        if($request->type == 'root'){
            $categories = $parent_cate->getImmediateDescendants();
        }else{
            $categories = $parent_cate->getDescendants();
        }

        return $categories;
    }

}
