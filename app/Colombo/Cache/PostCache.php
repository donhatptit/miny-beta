<?php
/**
 * Created by PhpStorm.
 * User: TinyPoro
 * Date: 9/20/18
 * Time: 11:35 AM
 */

namespace App\Colombo\Cache;


use App\Models\Category;
use App\Models\Post;

class PostCache
{
    public static function getHomeCategoryPosts(){
        $parent_cates = Category::with(['children' => function($query) {
            $query->select(['id', 'name', 'lft', 'rgt', 'parent_id', 'slug']);
        }])
            ->where('depth', 0)
            ->whereIn('status', [1,3] )
            ->limit(10)
            ->select(['id', 'name', 'lft', 'rgt', 'parent_id', 'slug'])
            ->get();

        $cates_posts = [];

        foreach ($parent_cates as $cate){
            $cate_posts = Post::where('is_approve', 1)
                ->whereIn('status', [1, 3])
                ->whereHas('category', function ($query) use( $cate ) {
                    $query->where('lft', '>=', $cate->lft);
                    $query->where('rgt', '<=', $cate->rgt);
                    })
                ->orderBy('updated_at', 'desc')->take(6)->select(['category_id', 'slug', 'title', 'content'])->get();

            if (count($cate_posts) >= 6){
                $cates_posts[] = [
                    'category' => $cate,
                    'posts' => $cate_posts
                ];
            }
        }

        return $cates_posts;
    }
}