<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Item\ReportRepository;
use App\Responses\Meta;
use App\Responses\ResObj;
use App\Responses\Response;
use App\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * @var ReportRepository
     */
    protected $reportRepository;

    /**
     * ProfileController constructor.
     *
     * @param ReportRepository $reportRepository
     */
    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function default(){
        $top_errors = \DB::table('reports')->select(\DB::raw('message, count(*) as err_count'))
            ->groupBy('message')
            ->orderBy('err_count', 'desc')
            ->limit(5)
            ->get();

        $meta = new Meta(200);
        $response = new Response();
        $response->setValue('data', $top_errors);
        $resObj = new ResObj($meta, $response);

        return response()->json($resObj);
    }

    public function postReport(Request $request){
        $auth_key = $request->header('authorization');
        $user = User::getUserFromAuthKey($auth_key);
        if(!$user){
            $meta = new Meta(400);
            $response = new Response();
            $resObj = new ResObj($meta, $response);

            return response()->json($resObj);
        }

        $message = $request->get('message');
        $type = $request->get('type');
        $device_info = $request->get('device_info');

        try{
            $this->reportRepository->create([
                'user_id' => $user->id,
                'message' => $message,
                'type' => $type,
                'device_info' => $device_info,
            ]);

            $meta = new Meta(200);
            $response = new Response();
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
