<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Responses\Meta;
use App\Responses\ResObj;
use App\Responses\Response;
use App\SearchHistory;
use App\User;
use Illuminate\Http\Request;

class SearchHistoryController extends Controller
{
    public function search(Request $request){
        $limit = $request->get('limit', 5);

        $auth_key = $request->header('authorization');
        $user = User::getUserFromAuthKey($auth_key);
        if(!$user){
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        $search_histories = SearchHistory::where('user_id', $user->id)->orderBy('updated_at', 'desc')->limit($limit)->get();

        $meta = new Meta(200);
        $response = new Response();
        $response->setValue('data', $search_histories);
        $resObj = new ResObj($meta, $response);

        return response()->json($resObj);
    }

    public function delete(Request $request){
        $auth_key = $request->header('authorization');
        $user = User::getUserFromAuthKey($auth_key);
        if(!$user){
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        $search_histories = SearchHistory::where('user_id', $user->id);
        $key = $request->get('key');

        if($key) $search_histories = $search_histories->where('keyword', $key);

        try{
            $search_histories->delete();

            $meta = new Meta(200);
            $response = new Response();
            $response->setValue('data', $search_histories);
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }catch (\Exception $e){
            $meta = new Meta(400, $e->getMessage());
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }
    }
}
