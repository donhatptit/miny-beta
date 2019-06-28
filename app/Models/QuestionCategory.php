<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Baum\Node;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Vinkla\Hashids\Facades\Hashids;

class QuestionCategory extends Node
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;


    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    const GOOGLE_INDEX = 1;
    const GOOGLE_NOINDEX = 0;

    const APPROVED = 1;
    const NOT_APPROVE = 0;

    const TYPE_NHANH_NHU_CHOP = 0;
    const TYPE_DO_VUI = 1;
    protected $table = 'questions_categories';
     protected $primaryKey = 'id';
//     public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'slug', 'player', 'parent_id', 'seo_title', 'seo_description','unapprove_reason','is_public','is_approve','approve_at'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
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
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function parent()
    {
        return $this->belongsTo('App\Models\QuestionCategory', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\QuestionCategory', 'parent_id');
    }

    public function questions(){
        return $this->hasMany(Question::class,'category_id');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    public function openDelete()
    {
        $id = $this->id;
        return view('vendor.backpack.crud.buttons.delete_custom',compact('id'));
    }
    // The slug is created automatically from the "name" field if no slug exists.
    public function getSlugOrNameAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }
        $cate_parent = QuestionCategory::find($this->parent_id);
        if ($cate_parent){

        return $cate_parent->slug." ".$this->name;
        }
        return $this->name;
    }

    public function getStatusView(){
        $html = '';
        if ($this->is_approve == 1){
            $html .= '<span class="label label-success">Đã duyệt</span>';
        }elseif($this->is_approve == 0){
            $html .= '<span class="label label-warning">Chưa duyệt</span>';
        }else{
            $html .= '<span class="label label-danger">Không duyệt</span>';
        }
        $html .= ' ';
        if ($this->is_public == 1){
            $html .= '<span class="label label-success">Public Google</span>';
        }else{
            $html .= '<span class="label label-warning">Private Google</span>';
        }
        return $html;
    }
    public function getTitleWithLink(){
        $html = '<a href="'.route('frontend.question', ['code'=>$this->code,'slug' => $this->slug]).'" target="_blank">'.$this->name.'</a>';
        if (!empty($this->seo_title)){
            $html .= '<br> <i>SEO Title</i>';
        }
        return $html;
    }

    public function getNameParentAttribute(){
        if($this->depth >0 ){
            $parent = str_repeat("-- ",$this->depth);
            $nameParent = $parent.$this->name;
        }else{
            $nameParent= $this->name;
        }
        return $nameParent;

    }

    public function save(array $options = [])
    {
        parent::save($options);
        $id_category = $this->id;
            $this->code = Hashids::connection()->encode($id_category);
        return parent::save($options);


    }


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
