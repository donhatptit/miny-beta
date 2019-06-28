<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class University extends Model
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

    protected $table = 'ts_universities';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['code', 'vi_name', 'en_name', 'keyword', 'phone', 'email', 'address', 'website', 'established', 'type', 'organization', 'avatar', 'scale', 'kind', 'location_id', 'description', 'created_by','slug', 'is_public', 'is_approve','edited_by', 'google_map'];
    // protected $hidden = [];
    // protected $dates = [];

    const UNIVERSITY_PUBLIC = 0;
    const UNIVERSITY_PRIVATE = 1;

    const UNIVERSITY = 0;
    const COLLEGE = 1;

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
                'source' => 'slug_or_vi_name',
            ],
        ];
    }



    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function user(){
        return $this->belongsTo(User::class, 'edited_by');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function images(){
        return $this->hasMany(Image::class,'university_id');
    }

    public function topics()
    {
        return $this->belongsToMany('App\Models\Topic', 'ts_university_topic');
    }

    public function posts(){
        return $this->hasMany(TsPost::class);
    }

    public function scores(){
        return $this->hasMany(Score::class);
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
        $html .= ' ';
        if ($this->edited_by !== 0){
            $html .= '<span class="label label-success">Đã sửa</span>';
        }else{
            $html .= '<span class="label label-warning">Chưa sửa</span>';
        }
        return $html;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setAvatarAttribute($value)
    {
        $attribute_name = "avatar";
        $disk_name  = "public";
        $destination_path = "uploads/university";
        // if the image was erased
        $disk = \Storage::disk($disk_name);
        if ($value == null) {
            $path = preg_replace('/(storage\/)/','', $this->{$attribute_name});
            // delete the image from disk
            $disk->delete($path);

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        if (starts_with($value, 'data:image'))
        {
            // 0. Make the image
            $image = \Image::make($value);
            // 1. Generate a filename.
            $filename = md5($value.time()).'.jpg';
            // 2. Store the image on disk.
            try{
                $disk->put($destination_path.'/'.$filename, $image->stream());
                // 3. Save the path to the database
                $path_image = 'storage/' . $destination_path . '/'.$filename;
            }catch(\Exception $e){
                $path_image = null;
            }
            if(!$disk->exists($destination_path . '/'.$filename)){
                $path_image = null;
            };
            $this->attributes[$attribute_name] = $path_image;
        }
    }
    public function getSlugOrViNameAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        return $this->vi_name;
    }
}
