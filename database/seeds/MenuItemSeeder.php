<?php

use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu_root = [];
        $menu_child = [];
        $categories = \App\Models\Category::where('depth',0)->whereIn('status',[1,3])->get();
        foreach($categories as $category){
            $menu_root[] = [
                'name' => $category->name,
                'type' => 'internal_link',
                'link' => '/danh-muc/' . $category->slug
            ];
        }
        foreach($categories as $key => $category){
            $cate_child = \App\Models\Category::where('parent_id', $category->id)->whereIn('status',[1,3])->get();
            foreach($cate_child as $child) {
                $menu_child[] = [
                    'name' => $child->name,
                    'type' => 'internal_link',
                    'link' => '/danh-muc/' . $child->slug,
                    'parent_id' => $key +1,
                ];
            }
        }
        foreach ($menu_root as $item){
            \App\Models\MenuItem::create($item);
        }
        foreach($menu_child as $item){
            \App\Models\MenuItem::create($item);
        }
    }
}
