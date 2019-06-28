<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Image extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'ts_images';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['title', 'disk', 'path', 'university_id', 'created_by'];
    // protected $hidden = [];
    // protected $dates = [];

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
    public function university()
    {
        return $this->belongsTo(University::class, 'university_id');
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
    public function getTitleWithLink(){
        $html = '<a href="'. config('app.url').'/' .$this->path .'" target="_blank">'.$this->title.'</a>';
        return $html;
    }

    public function getSizeAttribute(){
        try{
            list($width, $height) = getimagesize(config('app.url') . "/" . $this->path);
        }catch( \Exception $e){
            return '0x0';
        }

        return $width . 'x' . $height;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setPathAttribute($value)
    {
        $attribute_name = "path";
        $disk_name = "public";
        $destination_path = "uploads/university";
        // if the image was erased
        $disk = \Storage::disk($disk_name);
        if ($value == null) {
            $path = preg_replace('/(storage\/)/', '', $this->{$attribute_name});
            // delete the image from disk
            \Storage::disk($disk_name)->delete($path);

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db

        if (starts_with($value, 'data:image'))
        {
            // 0. Make the image
            $image = \Image::make($value);
            // 1. Generate a filename.
            $filename = md5($value.time()).'.jpg';
            // 2. Store the image on disk.
            try{
                \Storage::disk($disk_name)->put($destination_path.'/'.$filename, $image->stream());
            }catch(\Exception $e){
                $path_image = null;
            }
            if(!$disk->exists($destination_path . '/'.$filename)){
                $path_image = null;
            };
            // 3. Save the path to the database
            $this->attributes[$attribute_name] = 'storage/' . $destination_path . '/'.$filename;
        }
    }
}
