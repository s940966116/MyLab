<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Gregwar\Captcha\CaptchaBuilder;

class UserLogin extends Controller
{
    //確認登入
    public function checkLogin(Request $request){
        $userName = $request->name;
        $userPassword = $request->password;
        $vcode = $request->vcode;
        $userInfo = DB::select("select * from userinfos where name=:name", array("name"=>$userName));
        if(count($userInfo)){
            if($userPassword == $userInfo[0]->password){
                if($request->session()->get("vcode") == $vcode){
                    session(['login' => true]);
                    $ret['status'] = "success";
                    $ret['message'] = "登入成功";
                }else{
                    session(['login' => false]);
                    $ret['status'] = "fail";
                    $ret['message'] = "驗證碼錯誤";
                }
            } else {
                session(['login' => false]);
                $ret['status'] = "fail";
                $ret['message'] = "密碼錯誤";
            }
        } else {
            session(['login' => false]);
            $ret['status'] = "fail";
            $ret['message'] = "帳號錯誤";
        }
        return $ret;
    }

    //取得session
    public function checkLoginSession(Request $request){
        if(session('login')){
            $ret["ok"] = true;
        } else {
            $ret["ok"] = false;
        }
        return $ret;
    }

    //登出取消session
    public function cancelLoginSession(Request $request){
        $request->session()->put('login',false);
        if($request->session()->get('login')){
            $ret['logout'] = false;
        }else{
            $ret['logout'] = true;
        }
        return $ret;
    }

    public function getCaptcha(Request $request, $num){
        $builder = new CaptchaBuilder;
        $builder->build(120,36);

        $request->session()->put('vcode', $builder->getPhrase());

        return response($builder->output())->header('Content-type','image/jpeg');
    }
}
