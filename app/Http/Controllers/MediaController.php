<?php

namespace App\Http\Controllers;

class MediaController extends Controller
{
    public function showFile($filename, $folder = null){
        if($folder == null){
            $pathToFile = storage_path("media")."/$filename";
        }else{
            $pathToFile = storage_path("media")."/$folder"."/$filename";
        }

        if(file_exists($pathToFile)) return response()->file($pathToFile);
        else return "file đã bị xóa";
    }

    public function showImage($filename){
        $pathToFile = storage_path("images")."/$filename";
        if(file_exists($pathToFile)) return response()->file($pathToFile);
        else return "file đã bị xóa";
    }

}
