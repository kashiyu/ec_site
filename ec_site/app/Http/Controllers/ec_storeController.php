<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ec_storeController extends Controller{
    //トップページ
    public function index(){ 
        //ログイン情報取得
        $user_id = session('user_id');
        $user_name = session('user_name');

        //ログイン済か判断
        if(empty($user_id) === TRUE){
            return redirect('/ec/login')->with('error_message', '不正なアクセスです。');
            exit;
        }

        return view('ec_store',['user_name' => $user_name]);
    } 
}
