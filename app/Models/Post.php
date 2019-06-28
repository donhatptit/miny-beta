<?php

namespace App\Models;

use App\Core\Html2Text;
use App\User;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;
    use Searchable;

    const GOOGLE_INDEX = 1;
    const GOOGLE_NOINDEX = 0;

    const FINISH =1;
    const PENDING = 0;
    const CAN_NOT_OPEN_URL = -1;
    const CAN_NOT_SAVE_FILE = -2;

    const NOT_APPROVE = 0;
    const APPROVED = 1;
    const UNAPPROVE = -1;

    const DISPLAY_WEB = 1;
    const DISPLAY_MOBILE = 2;
    const DISPLAY_ALL = 3;
    const DISPLAY_HIDE = -1;
    const DISPLAY_DEFAULT = 1;
    const DISPLAY_TEXT = [
        1 => 'Hiển thị web',
        2 => 'Hiển thị App',
        3 => 'Hiển thị tất cả',
        -1 => 'Ẩn tất cả'
    ];


    const PHAN_TICH = 1;
    const CAM_NHAN = 2;
    const SOAN_BAI = 3;
    const TOM_TAT = 4;
    const DAN_Y = 5;
    const MIEU_TA = 6;
    const KE_CHUYEN = 7;
    const OTHER = 8;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'posts';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = ['slug', 'seo_title', 'title', 'subject', 'content', 'image', 'status', 'category_id', 'featured', 'date',
        'created_by', 'edited_by', 'description', 'is_public', 'is_approve','unapprove_reason','seo_description', 'count_word'];
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = [
        'featured'  => 'boolean',
        'date'      => 'date',
    ];

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
    /** cau hinh columns search */
    public function toSearchableArray()
    {
        return array_only($this->toArray(), ['title']);
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
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'post_tag');
    }

    public function user(){
        return $this->belongsTo(User::class, 'created_by');
    }
    public function post_answer(){
        return $this->hasMany(PostAnswer::class,'post_id');
    }

    public function kinds()
    {
        return $this->belongsToMany('App\Models\Kind', 'post_kind');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopePublished($query)
    {
        return $query->where('status', 'PUBLISHED')
                    ->where('date', '<=', date('Y-m-d'))
                    ->orderBy('date', 'DESC');
    }

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

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function getTitleWithLink(){
        $html = '<a href="'.route('frontend.post.detail', ['slug' => $this->slug]).'" target="_blank">'.$this->title.'</a>';
        if (!empty($this->seo_title)){
            $html .= '<br> <i>SEO Title</i>';
        }
        return $html;
    }

    public function getStatusView(){
        $html = '';
        if ($this->is_approve == 1){
            $html .= '<span class="label label-success">Đã duyệt</span>';
        }else if($this->is_approve == 0){
            $html .= '<span class="label label-warning">Chưa duyệt</span>';
        }else{
            $html .= '<span class="label label-danger">Xem xét</span>';
        }
        $html .= ' ';
        if ($this->is_public == 1){
            $html .= '<span class="label label-success">Public Google</span>';
        }else{
            $html .= '<span class="label label-warning">Private Google</span>';
        }
        if($this->is_handle == 1){
            $html .= '<span class="label label-success">Đã xử lý</span>';
        }elseif($this->is_handle == self::CAN_NOT_OPEN_URL ){
            $html .= '<span class="label label-danger">Lỗi ! URL</span>';
        }elseif($this->is_handle == self::CAN_NOT_SAVE_FILE ){
            $html .= '<span class="label label-danger">Lỗi ! SAVE</span>';
        }else{
            $html .= '<span class="label label-warning">Chưa xử lý</span>';
        }


        return $html;
    }
    public function getStatusText(){
        $status_text = 'None';

        switch ( $this->status ) {
            case self::DISPLAY_WEB:
                $status_text = 'Web';
                break;
            case self::DISPLAY_MOBILE:
                $status_text = 'Mobile';
                break;
            case self::DISPLAY_ALL:
                $status_text = 'All';
                break;
            case self::DISPLAY_HIDE:
                $status_text = 'Hide';
                break;
        }

        return $status_text;
    }
    public function getDescriptionAttribute(){
        $description = array_get($this->attributes, 'description');
        if(empty($description) || strlen($description) < 300){
            $html_to_text = new Html2Text($this->content);
            $content_text = $html_to_text->getPlainText();
            $content_text = str_replace(["\"", "\'", "(", ")", "*", "-", "_"], "", $content_text);
            if (strlen($content_text) > 300){
                $desc = mb_substr($content_text,0, 300);
            }else{
                $desc = $content_text;
            }
            $desc = str_replace(["\"", "\'", "(", ")", "*", "-", "_","\\"], "", $desc);
            return $desc;
        }
        return $description;

    }

    public function getLinkAttribute(){
        return route('frontend.post.detail', $this->slug);
    }

    public function getIdNextAttribute(){
        $next_category = Post::where('id', '>', $this->id)->where('is_approve', 1)->where('category_id', $this->category_id)->orderBy('id', 'asc')->first();

        if($next_category) return $next_category->id;
        return null;
    }
    public function getRootCateIdAttribute(){
        return Category::find($this->category_id)->getRoot()->id;
    }

    public static function getSavedAttribute($user_id, $post_id)
    {
        $user_offlines = \DB::table('user_offline')
            ->where('user_id', $user_id)
            ->where('target_id', $post_id)
            ->where('type', 'post')
            ->get();

        $saved = (count($user_offlines) == 0) ? false : true;

        return $saved;
    }
    public function save(array $options = [])
    {
        $existed = $this->exists;
        $old_is_approve = ( $existed ) ? $this->is_approve : self::NOT_APPROVE;

        $status =  parent::save($options);
        if($status){
            if(!$existed){
                $this->increaseAncestorAndSelfByCategoryColumn('num_posts');
            }

            $new_is_approve = $this->is_approve;

            if($new_is_approve == self::APPROVED && $old_is_approve != self::APPROVED) $this->increaseAncestorAndSelfByCategoryColumn('num_approved_posts');
            if($new_is_approve != self::APPROVED && $old_is_approve == self::APPROVED) $this->decreaseAncestorAndSelfByCategoryColumn('num_approved_posts');
        }
        return $status;
    }
    public function update(array $attributes = [], array $options = [])
    {
        $existed = $this->exists;
        $old_is_approve = ( $existed ) ? $this->is_approve : self::NOT_APPROVE;

        $status = parent::update($attributes, $options);
        if($status){
            $new_is_approve = $this->is_approve;

            if($new_is_approve == self::APPROVED && $old_is_approve != self::APPROVED) $this->increaseAncestorAndSelfByCategoryColumn('num_approved_posts');
            if($new_is_approve != self::APPROVED && $old_is_approve == self::APPROVED) $this->decreaseAncestorAndSelfByCategoryColumn('num_approved_posts');
        }
        return $status;
    }

    public function delete()
    {
        $is_approve = $this->is_approve;

        $status = parent::delete();
        if($status){
            $this->decreaseAncestorAndSelfByCategoryColumn('num_posts');

            if($is_approve){
                $this->decreaseAncestorAndSelfByCategoryColumn('num_approved_posts');
            }
        }
        return $status;

    }

    public function increaseAncestorAndSelfByCategoryColumn($column){
        $this->category->increment($column);

        $categories =   $this->category->getAncestors();
        foreach ($categories as $category){
            $category->increment($column);
        }
    }

    public function decreaseAncestorAndSelfByCategoryColumn($column){
        $this->category->decrement($column);

        $categories =   $this->category->getAncestors();
        foreach ($categories as $category){
            $category->decrement($column);
        }
    }
    public function getHasTagAttribute(){
       $count = $this->tags()->count();
       if($count > 0){
           return true;
       }else{
           return false;
       }
    }
}
