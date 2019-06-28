<?php

namespace App\Models;

use App\Core\Html2Text;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Vinkla\Hashids\Facades\Hashids;

class Question extends Model
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

    protected $table = 'questions';
     protected $primaryKey = 'id';
     public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = ['question','slug','answer','description','status','unapprove_reason','created_by','category_id','edited_by','number'];

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
                'source' => 'slug_or_title',
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
    public function category()
    {
        return $this->belongsTo('App\Models\QuestionCategory', 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'question_tag');
    }

    public function user(){
        return $this->belongsTo(User::class, 'created_by');
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

        return $this->question;
    }
    public function getLinksAttribute(){
        return route('frontend.question.detail', ['code'=>$this->code,'slug' => $this->slug]);
    }
    public function getLimitTitleAttribute(){
        return str_limit($this->question,50,"[...]");
    }

    public function getTitleWithLink(){

        $html = '<a href="'.$this->links.'" target="_blank">'.$this->limit_title.'</a>';
        if (!empty($this->seo_title)){
            $html .= '<br> <i>SEO Title</i>';
        }
        return $html;
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function save(array $options = [])
    {
        parent::save($options);
        if(empty($this->code)){
            $id_question = $this->id;
            $this->code = $this->getCodeQuestion($id_question);
        }
        return parent::save($options);
    }
    public function getCodeQuestion($id){
        $id = $id + 999;
        $code = Hashids::connection()->encode($id);
        $check = Question::where('code', $code)->first();
        if(!$check){
            return $code;
        }else{
            return $this->getCodeQuestion($id);
        }
    }

}
