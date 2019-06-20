<?php

namespace App\Http\Controllers;

use App\common\Base\TobException;
use App\Helpers\AtsException;
use App\Models\Member;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     version="3.0",
 *     title="Task Resource OpenApi",
 *     @OA\Contact(
 *         name="学院君",
 *         url="http://xueyuanjun.com",
 *         email="support@todo.test"
 *     )
 * ),
 * @OA\Server(
 *     url="http://homestead.test/"
 * ),
 * @OA\SecurityScheme(
 *     type="oauth2",
 *     description="Use a global client_id / client_secret and your email / password combo to obtain a token",
 *     name="passport",
 *     in="header",
 *     scheme="http",
 *     securityScheme="passport",
 *     @OA\Flow(
 *         flow="password",
 *         authorizationUrl="/oauth/authorize",
 *         tokenUrl="/oauth/token",
 *         refreshUrl="/oauth/token/refresh",
 *         scopes={}
 *     )
 * )
 */
class TestController extends Controller
{
    /**
     * @OA\Get(
     *     path="/",
     *     operationId="getTaskList",
     *     tags={"Tasks"},
     *     summary="Get list of tasks",
     *     description="Returns list of tasks",
     *     @OA\Parameter(
     *         name="Accept",
     *         description="Accept header to specify api version",
     *         required=false,
     *         in="header",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         description="The page num of the list",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         description="The item num per page",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The result of tasks"
     *     ),
     *     security={
     *         {"passport": {}},
     *     }
     * )
     */
    public function index()
    {
//        throw AtsException::error('100000');
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        return response()->json(['name'=>'test']);
    }

    const SALT = 1984;
    const SIZE_SALT = 8;
    /**
     * @OA\Get(
     *     path="/api/test",
     *     tags={"test"},
     *     summary="Get the title and page of article",
     *     description="Returns list of tasks",
     *     @OA\Parameter(
     *         name="title",
     *         description="the title of article",
     *         required=true,
     *         in="header",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         description="The page num of the list",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(response="200", description="An example resource")
     * )
     */
    public function test(Request $request)
    {
        $page = $request->input('page',1);
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        return response()->json(compact('title','page'),200);
    }
    private function _generateToken($prefix = '', $randSuffix = true)
    {
        $token = $prefix;
        if ($randSuffix) {
            list ($usec, $sec) = explode(' ', microtime());
            $token .= str_random(8);
            $time = round((float) $usec + (float) $sec, 3) * 1000;
            $token .= base_convert($time, 10, 32);
            // $token .= CommonUtil::generateRandStr(self::TOKEN_LENGTH - strlen($time), true) . $time;
        }
        return $token;
    }
}
