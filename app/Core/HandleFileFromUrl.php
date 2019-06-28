<?php
/**
 * Created by PhpStorm.
 * User: huyptit
 * Date: 08/11/2018
 * Time: 10:20
 */

namespace App\Core;
use App\Traits\FileUtils;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class HandleFileFromUrl
{
    use FileUtils;

    private $url;
    private $name_folder;
    private $image_path;
    const CAN_NOT_OPEN_URL = -1;
    const CAN_NOT_SAVE_FILE = -2;
    public function __construct($url, $name_folder = 'media')
    {
        $this->url = $url;
        $this->name_folder = $name_folder;
    }

    public function makeDirectory(){
        $media_path = storage_path('app/public/'. $this->name_folder);
        $time = Carbon::now();
        $this->date_current = $time->format('Y-m-d');

        if(!is_dir($media_path)){
            mkdir($media_path);
        }else{
            $this->image_path = $media_path . '/' . $this->date_current;
            if(!is_dir($this->image_path)){
                mkdir($this->image_path);
            }
        }
    }
    public function hanleMedia(){
        $this->makeDirectory();
        try{
            $extension = pathinfo($this->url,PATHINFO_EXTENSION);
            $name = pathinfo($this->url,PATHINFO_FILENAME);
            $filename = str_random(5) .'-'. $name . '.' . $extension;
            $content = file_get_contents($this->url);
        }catch(\Exception $e){
            Log::alert($e->getMessage());
            return self::CAN_NOT_OPEN_URL;
        }
        try{
            $save = file_put_contents($this->image_path . '/' . $filename, $content );
            $input_name = basename($filename);
            $data = asset('storage/' . $this->name_folder . '/'. $this->date_current . '/' . $input_name);
        }catch(\Exception $e){
            Log::alert($e->getMessage());
            return self::CAN_NOT_SAVE_FILE;
        }
        return $data;
    }

}