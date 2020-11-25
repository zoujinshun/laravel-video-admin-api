<?php
/*
 * @Author: your name
 * @Date: 2020-11-25 09:55:22
 * @LastEditTime: 2020-11-25 12:05:33
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: /api/app/Http/Middleware/VerifyApiRequest.php
 */

namespace App\Http\Middleware;

use App\Libs\AesCrypt;
use App\Libs\Response;
use Closure;
use Illuminate\Http\Request;

class VerifyApiRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //请求必须是post，content-type是txt
        if ($request->method() !== 'POST' || $request->getContentType() !== 'txt' || empty($content = $request->getContent())) {
            return Response::returnJsonData(Response::FAIL);
        }
        //解密
        $data = AesCrypt::decrypt($content);
        if (!$data || empty($data)) {
            return Response::returnJsonData(Response::FAIL);
        }
        //把请求参数注入到request中
        foreach ($data as $key => $value) {
            $request->request->set($key, $value);
        }

        return $next($request);
    }
}
