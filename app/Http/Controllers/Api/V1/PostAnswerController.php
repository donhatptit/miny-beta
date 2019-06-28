<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use App\Models\PostAnswer;
use App\Responses\Meta;
use App\Responses\ResObj;
use App\Responses\Response;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostAnswerController extends Controller
{
    public function upload_answer(Request $request){
        $auth_key = $request->header('authorization');
        $user = User::getUserFromAuthKey($auth_key);
        $content = $request->get('content');
        $post_id = $request->get('post_id');
        $post = Post::find($post_id);
        if(!$user || !$post){
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        $saved = PostAnswer::create([
            'content' => $content,
            'post_id' => $post_id,
            'created_by' => $user->id,
        ]);
        if($saved){
            $post->is_public = Post::GOOGLE_INDEX;
            $post->save();
            $meta = new Meta(200);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        $meta = new Meta(400);
        $response = new Response();
        $resObj = new ResObj($meta, $response);

        return response()->json($resObj);
    }
}
