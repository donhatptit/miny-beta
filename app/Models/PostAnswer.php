<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class PostAnswer extends Model
{

    use CrudTrait;
    protected $table = 'post_answer';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['content','post_id','created_by'];


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function user(){
        return $this->belongsTo(User::class, 'created_by');
    }
    public function post(){
        return $this->belongsTo(Post::class,'post_id');
    }
}
