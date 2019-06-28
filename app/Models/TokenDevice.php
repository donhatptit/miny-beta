<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class TokenDevice extends Model
{
    use CrudTrait;

    protected $table = 'token_devices';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id','token_device'];
     public $timestamps = true;

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
