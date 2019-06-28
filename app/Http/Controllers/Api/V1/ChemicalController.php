<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Chemical;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Responses\Meta;
use App\Responses\ResObj;
use App\Responses\Response;
use App\User;

class ChemicalController extends Controller
{
    public function upload_chemical(Request $request){
        $auth_key = $request->header('authorization');
        $user = User::getUserFromAuthKey($auth_key);
        if(!$user){
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }
        $symbol = $request->get('symbol');
        $name_vi = $request->get('name_vi');
        $name_eng = $request->get('name_eng');
        $color = $request->get('color');
        $state = $request->get('state');
        $g_mol = $request->get('g_mol');
        $kg_m3 = $request->get('kg_m3');
        $boiling_point = $request->get('boiling_point');
        $melting_point = $request->get('melting_point');
        $electronegativity = $request->get('electronegativity');
        $ionization_energy = $request->get('ionization_energy');

        $saved = Chemical::create([
            'symbol' => $symbol,
            'name_vi' => $name_vi,
            'name_eng' => $name_eng,
            'color' => $color,
            'state' => $state,
            'g_mol' => $g_mol,
            'kg_m3' => $kg_m3,
            'boiling_point' => $boiling_point,
            'melting_point' => $melting_point,
            'electronegativity' => $electronegativity,
            'ionization_energy' => $ionization_energy,

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
