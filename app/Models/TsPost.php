<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class TsPost extends Model
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;


    const GOOGLE_INDEX = 1;
    const GOOGLE_NOINDEX = 0;

    const NOT_APPROVE = 0;
    const APPROVED = 1;
    const UNAPPROVE = -1;


    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'ts_posts';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['title', 'slug', 'content', 'description', 'seo_title', 'seo_description', 'topic_id', 'university_id', 'is_public', 'is_approve', 'created_by', 'edited_by', 'published_at'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug_or_title',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function topic()
    {
        return $this->belongsTo('App\Models\Topic', 'topic_id');
    }

    public function university()
    {
        return $this->belongsTo('App\Models\University', 'university_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'ts_post_tag', 'post_id', 'tag_id');
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
    // The slug is created automatically from the "title" field if no slug exists.
    public function getSlugOrTitleAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        return $this->title;
    }

    public function getStatusView(){
        $html = '';
        if ($this->is_approve == 1){
            $html .= '<span class="label label-success">Đã duyệt</span>';
        }else{
            $html .= '<span class="label label-warning">Chưa duyệt</span>';
        }
        $html .= ' ';
        if ($this->is_public == 1){
            $html .= '<span class="label label-success">Public Google</span>';
        }else{
            $html .= '<span class="label label-warning">Private Google</span>';
        }
        return $html;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function getTitleWithLink(){
        $html = '<a href="'.route('admission.university.post', ['slug' => $this->slug]).'" target="_blank">'.$this->title.'</a>';
        return $html;
    }
    public function getTagsInputAttribute(){
        $tags = $this->tags->pluck('name')->toArray();
        return implode(',', $tags);
    }
}
