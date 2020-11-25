<?php
/*
 * @Author: your name
 * @Date: 2020-11-25 10:59:14
 * @LastEditTime: 2020-11-25 11:31:51
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: /api/app/Libs/Response.php
 */
namespace App\Libs;

class Response
{

    const FAIL = 0;
    const LOGIN_FAIL = -1;

    const MSG = [
        self::FAIL => '请求失败',
        self::LOGIN_FAIL => '登录失败，用户名或密码错误',
    ];

    /**
     * @description: json输出格式化
     * @author: zjs
     * @param int $code 状态码
     * @param array $data 数据
     * @return {*}
     */
    public static function returnJsonData(int $code = 0, array $data = [])
    {

        $formatData = [
            'code' => $code,
            'msg' => self::MSG[$code],
            'data' => $data,
        ];
        return response()->json($formatData);
    }
}
