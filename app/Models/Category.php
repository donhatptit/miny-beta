<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Baum\Node;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Category extends Node
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;


    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    const DISPLAY_WEB = 1;
    const DISPLAY_MOBILE = 2;
    const DISPLAY_ALL = 3;
    const DISPLAY_HIDE = -1;

    const DISPLAY_TEXT = [
      1 => 'Hiển thị web',
      2 => 'Hiển thị App',
      3 => 'Hiển thị tất cả',
      -1 => 'Ẩn tất cả'
    ];

    const TYPE_CLASS = 'class';

    protected $table = 'categories';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'slug', 'parent_id', 'seo_title', 'seo_description', 'status', 'type', 'description_top', 'description_bottom'];
    // protected $hidden = [];
    // protected $dates = [];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug_or_name',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_id');
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeFirstLevelItems($query)
    {
        return $query->where('depth', '1')
                    ->orWhere('depth', null)
                    ->orderBy('lft', 'ASC');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    // The slug is created automatically from the "name" field if no slug exists.
    public function getSlugOrNameAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        return $this->name;
    }

    public function getLinkAttribute(){
        return route('frontend.category.index', [
            'slug' => $this->slug
        ], false);
    }
    public function getNameParentAttribute(){
        if($this->depth >0 ){
            $parent = str_repeat("== ",$this->depth);
            $nameParent = $parent.$this->name;
        }else{
            $nameParent= $this->name;
        }
        return $nameParent;

    }
    public function getBooleanSeoTitleAttribute(){
        if($this->seo_title!==null){
            return true;
        }
        return false;
    }
    public function getBooleanSeoDescriptionAttribute(){
        if($this->seo_description!==null){
            return true;
        }
        return false;
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function getAllPosts($number = 0){
        $post_builder = Post::where('is_approve', 1)
            ->whereIn('status', [1, 3])
            ->whereHas('category', function ($query){
                $query->where('lft', '>=', $this->lft);
                $query->where('rgt', '<=', $this->rgt);
            })
            ->orderBy('updated_at', 'desc')->select(['category_id', 'slug', 'title', 'content']);

        if ($number > 0){
            $post_builder = $post_builder->limit($number);
        }

        $posts = $post_builder->get();

        return $posts;
    }
    public function paginationPosts($perPage = 10){
        $posts = Post::where('is_approve', 1)
            ->whereIn('status', [1, 3])
            ->whereHas('category', function ($query){
                $query->where('lft', '>=', $this->lft);
                $query->where('rgt', '<=', $this->rgt);
            })
            ->orderBy('updated_at', 'desc')
            ->select(['category_id', 'slug', 'title', 'content'])
            ->simplePaginate($perPage);

        return $posts;
    }

    public function getAllDescendantsId(){
        /** @var $root_cate Node*/
        $descendants = $this->getDescendantsAndSelf()->toArray();
        $descendant_ids = [];
        foreach ($descendants as $descendant){
            $descendant_ids[] = $descendant['id'];
        }

        return $descendant_ids;
    }
    // Lấy ra cate môn học từ một cate bài học bất kỳ
    public function getCategorySubject(){
        $category_subject = Category::where('lft', '<', $this->lft)->where('rgt', '>', $this->rgt)->where('depth', 1)->select(['name', 'slug', 'parent_id', 'lft', 'rgt', 'depth'])->first();
        if($category_subject){
            return $category_subject;
        }
        return null;

    }
}
