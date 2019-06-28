<?php
/**
 * Created by PhpStorm.
 * User: TinyPoro
 * Date: 9/8/18
 * Time: 10:01 AM
 */

namespace App\Http\Controllers\Api\V1;


use App\Models\ChemicalEquation;
use App\Models\EquationTag;
use App\Responses\Meta;
use App\Responses\ResObj;
use App\Responses\Response;
use App\User;
use Illuminate\Http\Request;

class EquationController
{
    public function upload_equation(Request $request){
        $auth_key = $request->header('authorization');
        $user = User::getUserFromAuthKey($auth_key);
        if(!$user){
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        $equation = $request->get('equation');
        $condition = $request->get('condition');
        $execute = $request->get('execute');
        $phenomenon = $request->get('phenomenon');
        $extra = $request->get('extra');
        $tags = $request->get('tags');

        $saved = ChemicalEquation::create([
            'equation' => $equation,
            'condition'=> $condition,
            'execute'=> $execute,
            'phenomenon' => $phenomenon,
            'extra' => $extra,
            'created_by' => $user->id
        ]);

        if($saved){
            //gắn tag cho equation

            foreach ($tags as $tag){
                $tag_obj = EquationTag::firstOrCreate(['name' => $tag]);

                if($tag_obj){
                    /** @var $saved ChemicalEquation */
                    $saved->attach($tag_obj->id);
                }
            }

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

    public function list(Request $request){
        $limit = $request->get('limit');

        $equations = ChemicalEquation::take($limit)->orderBy('created_at', 'desc')->get();

        return response()->json($equations);
    }
}