<?php
/**
 * Created by PhpStorm.
 * User: huyptit
 * Date: 13/02/2019
 * Time: 13:08
 */

namespace App\Core;


use GrahamCampbell\Flysystem\Facades\Flysystem;
use App\Core\ImageTemplate\Large;
use App\Core\ImageTemplate\Medium;
use Illuminate\Support\Facades\Storage;


class MyStorage
{

    /**
     * Lấy ổ đĩa mặc định của hệ thống
     * @return \League\Flysystem\Filesystem
     */
    public static function getDefaultDisk(){
        return self::getDisk(config('flysystem.default'));
    }

    /**
     * Lấy ổ đĩa tương ứng để thao tác
     * @param $disk
     * @return \League\Flysystem\Filesystem
     */
    public static function getDisk($disk){
        return Storage::disk($disk);
    }


    /**
     * Lấy đường dẫn ảnh tùy thuộc vào các disk khác nhau
     * @todo chú ý từng disk khác nhau cần được ỗ trợ để có thể hiển thị.
     * @param $disk
     * @param $path
     * @param $template
     * @return string
     */
    public static function get_image_link($disk, $path, $template = 'medium'){

        return self::getThumbLinkAttribute($disk, $path,$template);

    }


    /**
     * Load ảnh cache
     * @param $disk
     * @param $path
     * @param $template
     * @return $path
     */
    public static function getThumbLinkAttribute($disk, $path, $template = 'medium', $flag = true){
        if($template == 'original'){
            $template = 'large';
        }
        $path = str_replace('storage/', '', $path);
        $default =   url('/default/img/default.png');
        $image   =   ($path == "") ? $default : $path;
        try{

            $dir     = dirname($image);
            $file    = basename($image);
            $path_create = public_path('storage/caches/'. $template . '/' . $dir);

            if(!\File::exists($path_create . '/' . $file)){
                if($flag){
                    \File::makeDirectory($path_create, $mode = 0777, true, true);
                }

                $cache   =  $path_create . '/' . $file;
                $tmp     = config('imagecache.templates.'.$template);

                \Image::make(MyStorage::getDisk($disk)->readStream($image))->filter(new $tmp)->save($cache);
            }

            return url('/storage/caches/' . $template . '/' . self::pathToLink($path));

        } catch (\Exception $ex){
            \Log::error('MyStorage::row 82 Lỗi trong hàm getThumbLinkAttribute: ' . $ex->getMessage());
            return $default;
        }
    }

    public static function pathToLink($path){
        return str_replace('\\', '/', $path);
    }



}