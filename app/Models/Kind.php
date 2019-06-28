<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Kind extends Model
{
    use CrudTrait;

    protected $table = 'kinds';
    protected $fillable = ['name','color'];



    public function posts()
    {
        return $this->belongsToMany('App\Models\Post', 'post_kind');
    }
}
