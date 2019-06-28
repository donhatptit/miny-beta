<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Score;
use App\Models\TsPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Responses\Meta;
use App\Responses\ResObj;
use App\Responses\Response;
use App\User;
use Illuminate\Support\Facades\Log;

class UniversityController extends Controller
{
    public function uploadScore(Request $request){
            $auth_key = $request->header('authorization');
            $user = User::getUserFromAuthKey($auth_key);
            if (!$user) {
                $meta = new Meta(400);
                $response = new Response();
                $resObj = new ResObj($meta, $response);

                return response()->json($resObj);
            }
            $scores = $request->get('scores');
            $scores_fail = [];
            if(count($scores) > 0){
                foreach($scores as $score){
                    $result = $this->createScore($score);
                    if(!empty($result)){
                        $scores_fail[] = $result;
                    }
                }
                $meta = new Meta(200);
                $response = new Response();
                $response->setValue('data', $scores_fail);
                $resObj = new ResObj($meta, $response);
                return response()->json($resObj);
            }
        $meta = new Meta(400);
        $response = new Response();
        $resObj = new ResObj($meta, $response);
        return response()->json($resObj);
    }
    private function createScore($score){
        $id_local = array_get($score, 'id');
        $name = array_get($score, 'name');
        $code = array_get($score, 'code');
        $group_subject = array_get($score, 'group_subject');
        $point = array_get($score, 'point');
        $note = array_get($score, 'note');
        $year = array_get($score, 'year');
        $university_id = array_get($score, 'university_id');
        try{
            $saved = Score::create([
                'name' => $name,
                'code' => $code,
                'group_subject' => $group_subject,
                'point' => $point,
                'note' => $note,
                'year' => $year,
                'university_id' => $university_id,
            ]);
            if(!$saved){
                return $id_local;
            }
        }catch (\Exception $e){
            return $id_local;
        }
        return null;
    }
    public function uploadPost(Request $request){
        $auth_key = $request->header('authorization');
        $user = User::getUserFromAuthKey($auth_key);
        if(!$user){
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        $title = $request->get('title');
        $content = $request->get('content');
        $category_id = $request->get('university_id');
        $description = $request->get('description');

        $saved = TsPost::create([
            'title' => $title,
            'content' => $content,
            'university_id' => $category_id,
            'created_by' => $user->id,
            'description' => $description,
        ]);

        if($saved){
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
