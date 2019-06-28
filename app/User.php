<?php

namespace App;

use App\Models\PostAnswer;
use App\Models\Post;
use App\Models\Question;
use App\Models\QuestionCategory;
use App\Models\TokenDevice;
use App\Models\University;
use Backpack\CRUD\CrudTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use CrudTrait; // <----- this
    use HasRoles; // <------ and this
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','google_id','facebook_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function post(){
        return $this->hasMany(Post::class,'created_by');
    }
    public function questions(){
        return $this->hasMany(Question::class,'created_by');
    }
    public function category_question(){
        return $this->hasMany(QuestionCategory::class,'created_by');
    }
    public function isAdmin(){
        return $this->hasRole('Administrator');
    }
    public function token_devices(){
        return $this->hasMany(TokenDevice::class,'user_id');
    }
    public function post_answer(){
        return $this->hasMany(PostAnswer::class,'created_by');
    }
    public function university(){
        return $this->hasMany(University::class,'created_by');
    }

    public static function getUserFromAuthKey($auth_key){
        $token = str_replace('Bearer ', '', $auth_key);

        $user = User::where('api_token', $token)->first();

        if($user) return $user;
        return null;
    }
}
