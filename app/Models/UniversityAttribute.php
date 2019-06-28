<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class UniversityAttribute extends Model
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    const XET_TUYEN = 0;
    const DIEM_CHUAN = 1;
    const HOC_PHI = 2;
    const EXTRA = 3;

    const GOOGLE_INDEX = 1;
    const GOOGLE_NOINDEX = 0;

    const NOT_APPROVE = 0;
    const APPROVED = 1;
    const UNAPPROVE = -1;

    const FINISH = 2;
    const PENDING = 1;
    const DRAFT   = 0;
    const CAN_NOT_OPEN_URL = -1;
    const CAN_NOT_SAVE_FILE = -2;


    protected $table = 'ts_university_attributes';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['title', 'content', 'type', 'slug', 'seo_title', 'seo_description', 'university_id', 'year', 'is_approve', 'is_public', 'created_by', 'is_handle'];
    // protected $hidden = [];
    // protected $dates = [];

    public static $text_type = [
        self::XET_TUYEN => 'Xét tuyển',
        self::DIEM_CHUAN => 'Điểm chuẩn',
        self::HOC_PHI => 'Học phí',
        self::EXTRA => 'Thông tin thêm',
    ];
    public static $status = [
        self::DRAFT => 'Nháp',
        self::PENDING => 'Chờ xử lý',
        self::FINISH  => 'Đã xử lý'
    ];
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

        switch ($this->is_handle) {
            case self::FINISH :
                $html .= '<span class="label label-success">Đã xử lý</span>';
                break;
            case self::PENDING :
                $html .= '<span class="label label-info">Chờ xử lý</span>';
                break;
            case self::DRAFT :
                $html .= '<span class="label label-warning">Chờ duyệt</span>';
                break;
            case self::CAN_NOT_OPEN_URL :
                $html .= '<span class="label label-danger">Lỗi ! URL</span>';
                break;
            case self::CAN_NOT_SAVE_FILE :
                $html .= '<span class="label label-danger">Lỗi ! SAVE</span>';
                break;
        }

        return $html;
    }

    public function getTitleWithLink(){
        if($this->type == self::XET_TUYEN){
            $html = '<a href="'.route('university.index', ['slug' => $this->university->slug]).'" target="_blank">'.$this->title.'</a>';
        }else{
            $html = '<a href="'.route('university.score', ['slug' => $this->university->slug]).'" target="_blank">'.$this->title.'</a>';
        }
        return $html;
    }


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
