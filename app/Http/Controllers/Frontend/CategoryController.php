<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Category;

use App\Repositories\Frontend\Item\CategoryRepository;
use App\Repositories\Frontend\Item\PostRepository;
use Illuminate\Http\Request;

class CategoryController extends FrontendController
{
    public function __construct(CategoryRepository $categoryRepository, PostRepository $postRepository)
    {
        parent::__construct($categoryRepository, $postRepository);
    }

    public function index(Request $request, $slug)
    {
        $category_current = $this->categoryRepository->findCategoryBySlug($slug);
//        dd($category_current);
        if (!$category_current) {
            return abort(404);
        }
        // Hien thi sanh sach mon khi an vao lop
        if ($category_current->depth === 0) {
            $categories = $category_current->children;
            if (preg_match('/(^lop-\d+)/', $category_current->slug, $matches)) {
                $type = 'class';
                $title = "Giải chi tiết toàn bộ môn học " . $category_current->name;
            } elseif($category_current->slug == 'cong-thuc') {
                $type = 'formula';
                $title = "Tổng hợp " . $category_current->name . " các môn học chi tiết nhất";
                dd($title);
            }elseif($category_current->slug == 'ban-co-biet'){
                $type = 'youknow';
                $title = 'Mẹo học tập theo từng môn học đầy đủ nhất';
            }
            $this->setSeoMeta($this->getSeoTitle($category_current), $this->getSeoDescription($category_current));
            $this->setIndexSEO(true);
            return view('frontend.categories.index', [
                'categories' => $categories,
                'category_current' => $category_current,
                'title' => $title,
            ]);
            // Hien thi danh sach cac bai post khi an vao bai hoc
        } elseif ($category_current->isLeaf()) {
            if ($category_current->depth == 1) {
                $category_subject = $category_current;
            } else {
                $category_subject = $category_current->getCategorySubject();
            }

            $category_root = $category_current->getRoot();
            if(preg_match('/^ngu-van/', $category_subject->slug, $arr_subject)){
                $subject = 'ngu-van';
            }else{
                $subject = 'other';
            }
            if (preg_match('/(^lop-\d+)/', $category_root->slug, $matches)) {
                $type = 'class';
                if($subject == 'ngu-van'){
                    $title = $category_current->name . " (Ngắn gọn nhất) - " . $category_subject->name;
                }else{
                    $title = $category_current->name . " - " . $category_subject->name;
                }

            }  elseif($category_root->slug == 'cong-thuc') {
                $type = 'formula';
                $title = $category_current->name . " đầy đủ và chi tiết nhất";
            }elseif($category_root->slug == 'ban-co-biet') {
            $type = 'youknow';
            $title = "Tổng hợp các " . $category_current->name . " hữu ích nhất";
        }

            $category_siblings = $category_current->getSiblings(array('name', 'slug', 'id'))->take(10);
            if($subject == 'ngu-van'){
                $posts = $this->postRepository->getAllPostByIdCategory($category_current->id, 20, 'count_word');
            }else{
                $posts = $this->postRepository->getAllPostByIdCategory($category_current->id, 20, 'title');
            }


           $this->setSeoMeta($this->getSeoTitle($category_current), $this->getSeoDescription($category_current));
            $this->setIndexSEO(true);

            if(!empty($category_subject)){
                $categories_sidebar = $category_subject->getDescendantsAndSelf(['slug', 'name','depth']);
            }else{
                $categories_sidebar = null;
            }
            return view('frontend.categories.index3', [
                'category_current' => $category_current,
                'posts' => $posts,
                'title' => $title,
                'category_siblings' => $category_siblings,
                'parent_category' => $category_subject,
                'subject' => $subject,
                'categories_sidebar' => $categories_sidebar,

            ]);
        } else {
            // Hien thi danh sach cac bai hoc khi an vao mon hoc
            $category_root = $category_current->getRoot();
            $categories = $category_current->getImmediateDescendants(array('name', 'depth', 'slug', 'parent_id', 'lft', 'rgt', 'id'));
            if (preg_match('/(^lop-\d+)/', $category_root->slug, $matches)) {
                $type = 'class';
                $title = "Giải chi tiết bài tập " . $category_current->name;
            } elseif($category_root->slug == 'cong-thuc') {
                $type = 'formula';
                $title = $category_current->name . " đầy đủ và chi tiết nhất";
            }elseif($category_root->slug == 'ban-co-biet') {
                $type = 'youknow';
                $title = "Tổng hợp các " . $category_current->name . " hữu ích nhất";
            }
           $this->setSeoMeta($this->getSeoTitle($category_current), $this->getSeoDescription($category_current));
            $this->setIndexSEO(true);
            return view('frontend.categories.index2', [
                'category_current' => $category_current,
                'categories' => $categories,
                'title' => $title

            ]);
        }

    }

    private function getSeoTitle(Category $category)
    {
        if (!empty($category->seo_title)) {
            $seo_title = $category->seo_title;
        } else {
            $seo_title = $category->name . config('seotools.meta.defaults.additional_category_title');
        }

        return $seo_title;
    }

    private function getSeoDescription(Category $category)
    {
        if (!empty($category->seo_description)) {
            $seo_description = $category->seo_description;
        } else {
            $seo_description = '';
        }

        return $seo_description;
    }

}