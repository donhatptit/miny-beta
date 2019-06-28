<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Report extends Model
{
    use CrudTrait;

    protected $table = 'reports';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'message',
        'type',
        'device_info',
    ];
    const REASON = [
        'Sai chính tả',
        'Giải khó hiểu',
        'Giải sai',
        'Lỗi khác'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }


    public function getReasonAttribute(){
        $pattern = "/(?<=\,\[)((\s|)(true|false)(\,|))((\s|)(true|false)(\,|))((\s|)(true|false)(\,|))((\s|)(true|false)(\,|))(?=\])/";
        preg_match($pattern,$this->message,$matches);
        $reason = array_get($matches,0,null);
        $arr_reason = preg_split('/(\,\s+|\,|\s+)/', $reason);
        $data = [];
        foreach($arr_reason as $key => $value){
            if($value == 'true'){
                $data[] = array_get(self::REASON,$key);
            }
        }
        return $data;
    }
    public function getDescriptionAttribute(){
        $pattern = "/(\,\[)((\s|)(true|false)(\,|))((\s|)(true|false)(\,|))((\s|)(true|false)(\,|))((\s|)(true|false)(\,|))(\])/";
        $message = preg_replace($pattern,'',$this->message);
        return $message;
    }
}

