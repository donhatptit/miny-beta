<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Responses\Meta;
use App\Responses\ResObj;
use App\Responses\Response;
use App\Traits\FileUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MultipartController extends Controller
{
    use FileUtils;

    private $image_path;
    private $date_current;

    public function __construct(){
        $media_path = storage_path('app/public/media');
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

    public function postMedia(Request $request){
        $url = $request->get('url');
        if(!$url){
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }
        try{

            $extension = pathinfo($url,PATHINFO_EXTENSION);
            $name = pathinfo($url,PATHINFO_FILENAME);
            $filename = str_random(5) .'-'. $name . '.' . $extension;
            $file = file_get_contents($url);
            $save = file_put_contents($this->image_path . '/' . $filename, $file );
            if($save){
                $input_name = basename($filename);
                $data = asset('storage/media/'. $this->date_current . '/' . $input_name);
                $meta = new Meta(200);
                $response = new Response();
                $response->setValue('data', $data);
            }else{
                $meta = new Meta(400);
                $response = new Response();

            }
        }catch(\Exception $e){
            Log::warning($e->getMessage());
            $meta = new Meta(400);
            $response = new Response();
        }


        $resObj = new ResObj($meta, $response);
        return response()->json($resObj);
    }

    public function uploadImage(Request $request) {
        $this->validate($request, [
            'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $name = $image->getBasename().'.'.$image->getClientOriginalExtension();
            $destinationPath = storage_path('/images');
            $image->move($destinationPath, $name);

            $data = route('show.image', ['$filename' => $name]);

            $meta = new Meta(200);
            $response = new Response();
            $response->setValue('data', $data);
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        $meta = new Meta(400);
        $response = new Response();
        $resObj = new ResObj($meta, $response);

        return response()->json($resObj);
    }
}
