<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserLogin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name("index");

//確認登入
Route::post('/checkLogin', [UserLogin::class, "checkLogin"]);
//確認登入session
Route::get('/checkLoginSession', [UserLogin::class, "checkLoginSession"]);
//登出
Route::get('/cancelLoginSession', [UserLogin::class, "cancelLoginSession"]);
//驗證碼
Route::get('/getCaptcha/{num}', [UserLogin::class, "getCaptcha"]);
