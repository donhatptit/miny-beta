<?php
/**
 * Created by PhpStorm.
 * User: TinyPoro
 * Date: 9/20/18
 * Time: 11:35 AM
 */

namespace App\Colombo\Cache;


use App\Models\Category;
use App\Models\MenuItem;

class CategoryCache
{
    public static function getFrontendHeaderCategories(){
        $home_cates = MenuItem::with(['children' => function($query) {
            $query->select('id','name','type','link','parent_id','lft','rgt','depth');
        }])
            ->where('depth', 0)
            ->orderBy('lft')
            ->get();
        return $home_cates;
    }

    public static function getFrontendFooterCategories(){
        $ids = explode(',', config('view.footer_categories.ids'));
        return Category::select(['name', 'slug'])->whereIn('id', $ids)->limit(5)->get();
    }
}