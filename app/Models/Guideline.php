<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Guideline extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'guideline';
     protected $primaryKey = 'id';
     public $timestamps = true;

    protected $fillable = ['title', 'content'];


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function getTitleWithLink() {
        $link = "guideline-detail/$this->id";
        return "<a href='$link'>$this->title</a>";
    }
}
