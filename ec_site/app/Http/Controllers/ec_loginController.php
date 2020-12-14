<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\users;
use App\Http\Requests\login_requests;
use Illuminate\Support\Facades\Log;

class ec_loginController extends Controller{

    //ログイン画面
    public function index(){ 
        return view('login');
    } 

    //ログイン処理
    public function login(login_requests $request){ 

        //インスタンス化
        $user = new users();
        //入力したユーザーが存在するなら取得
        $login_user = $user->login_user($request);

        //取得できたか判断
        if(empty($login_user) === TRUE){
            return redirect('/ec/login')->with('error_message', 'ユーザー名又はパスワードが違います。');
            exit;
        }
        //ログインユーザーの情報をセッションに保存
        session(['user_id'   => $login_user[0]->id]);
        session(['user_name' => $login_user[0]->user_name]);
        session(['adm_flag'  => $login_user[0]->adm_flag]);

        //管理者権限があるか判断
        $admin = '1';
        if($login_user[0]->adm_flag === $admin){
            //商品管理ページ（管理者権限あり）
            return redirect('/ec/tool');
        }else{
            //ECトップページ（管理者権限なし）
            return redirect('/ec/store');
        }
    }

    //ログアウト処理
    public function logout(){

        //セッション削除
        session()->flush();
        
        return redirect('/ec/login')->with('success_message', 'ログアウトしました');
    }

    //ユーザー登録ページ
    public function register_page(){
        
        return view('register');
    }

    //ユーザー登録ページ
    public function register(login_requests $request){

        //インスタンス化
        $user = new users();
        //入力したユーザーが存在するなら取得
        $registered_user = $user->registered_user($request);

        if(empty($registered_user) !== TRUE){
            return redirect('/ec/register')->with('error_message', '同じユーザー名が既に登録されています');
        }

        //ユーザー登録
        $user->register($request);

        return redirect('/ec/login')->with('success_message', 'ユーザーを登録しました');
    }

}
