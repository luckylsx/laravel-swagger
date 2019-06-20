<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use function OpenApi\scan;
use OpenApi\Util;

/**
 * @Swagger(
 *     schemes={"http://homestead.test"},
 *     basePath="/",
 *     consumes={"application/json"},
 *     tags={
 *         @SWG\Tag(
 *             name="API",
 *             description="API接口"
 *         )
 *     }
 * )
 *
 * @Info(
 *  title="API文档",
 *  version="0.1"
 * )
 *
 * @return mixed
 */
class SwaggerController extends Controller
{
    /**
     * 假设是项目中的一个API
     *
     * @SWG\Get(path="/swagger/docs",
     *   tags={"docs"},
     *   summary="拿一些神秘的数据",
     *   description="请求该接口需要先登录。",
     *   operationId="getMyData",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="reason",
     *     type="string",
     *     description="拿数据的理由",
     *     required=true,
     *   ),
     *   @SWG\Response(response="default", description="操作成功")
     * )
     */
    public function doc(Request $request)
    {
//        $swagger = \Swagger\scan(app_path('Http/Controllers/'));
//        $swagger = \Swagger\scan(realpath(__DIR__.'/../../'));
        $openapi = \OpenApi\scan(app_path('Http/Controllers/'));
        header('Content-Type: application/x-yaml');

        return $openapi->toYaml();
    }

    /**
     * 假设是项目中的一个API
     *
     * @SWG\Get(path="/swagger/my-data",
     *   tags={"project"},
     *   summary="拿一些神秘的数据",
     *   description="请求该接口需要先登录。",
     *   operationId="getMyData",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="reason",
     *     type="string",
     *     description="拿数据的理由",
     *     required=true,
     *   ),
     *   @SWG\Response(response="default", description="操作成功")
     * )
     */
    /**
     *
     * swagger json 文件生成
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function docOfModule(Request $request)
    {
        if (env('APP_ENV') == 'pro') {
            return response('', 403);
        }
        header("Access-Control-Allow-Origin: *");

        $finder = Util::finder(__DIR__ . '/../../' . $request->input('module', ''));

        $finder->append([
            realpath(__DIR__ . '/../../Common/Support/Result.php'),
            realpath(__DIR__ . '/../../Http/Controllers/SwaggerController.php'),
        ]);
        $swagger = scan($finder);
        return response()->json($swagger);
    }
}
