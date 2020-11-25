<?php
/*
 * @Descripttion:
 * @Autor: zjs
 * @Date: 2020-11-18 00:40:17
 * @LastEditTime: 2020-11-25 11:23:15
 * @FilePath: /routes/api.php
 */

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Libs\AesCrypt;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::any('/test',function(Request $request){
    dd(AesCrypt::encrypt($request->all()));
});

/**
 * 登录认证
 */
Route::any('/auth/login', [UserController::class, 'login']);
