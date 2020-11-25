<?php
/*
 * @Descripttion: 用户模块
 * @Autor: zjs
 * @Date: 2020-11-25 08:12:50
 * @LastEditTime: 2020-11-25 12:04:03
 * @FilePath: /app/Http/Controllers/Api/UserController.php
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libs\{Response,AesCrypt};
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @description: 用户登录
     * @author: zjs
     * @return
     */
    public function login(Request $request)
    {
        //dd(AesCrypt::encrypt(["account" => "123456", "password" => "dlyzjs"]));
        $account = $request->account;
        $password = $request->password;
        $user = User::where('account', $account)->first();
        if (!$user || !Hash::check($password, $user->password)) {
            return Response::returnJsonData(Response::LOGIN_FAIL);
        }
    }
}
