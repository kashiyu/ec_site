<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\item;
use App\Models\users;
use App\Http\Requests\add_item_requests;
use App\Http\Requests\change_stock_requests;
use Illuminate\Support\Facades\Log;

class ec_toolController extends Controller{

    //商品管理画面
    public function index(){ 
        //ログイン情報取得
        $user_id = session('user_id');
        $user_name = session('user_name');
        $adm_flag = session('adm_flag');

        //ログイン済か判断
        if(empty($user_id) === TRUE){
            return redirect('/ec/login')->with('error_message', '不正なアクセスです。');
            exit;
        //管理者権限(1)があるか判断
        }else if($adm_flag !== "1"){
            return redirect('/ec/store');
        }

        //モデルへリクエスト
        $item = new item();
        $items = $item->items();

        return view('ec_tool',
        ['item' => $items],
        ['user_name' => $user_name],);
    } 
    //商品追加
    public function add_item(add_item_requests $request){ 

        //モデルへリクエスト
        $item = new item();
        $errors = $item->add_item_model($request);

        if(empty($errors) === true){
            return redirect('/ec/tool')->with('success_message', '追加しました');
        }else{
            return redirect('/ec/tool')->with($errors);
        }
    }
    
    //商品削除
    public function delete_item(request $request){

        //モデルへリクエスト
        $item = new item();
        $item->delete_item_model($request);

        return redirect('/ec/tool')->with('success_message', '削除しました');
    }

    //商品ステータス変更
    public function change_status(request $request){ 

        //モデルへリクエスト
        $item = new item();
        $item->change_status_model($request);

        return redirect('/ec/tool')->with('success_message', 'ステータスを変更しました');
    }

    //在庫数変更
    public function change_stock(change_stock_requests $request){ 

        //インスタンス化
        $item = new item();
        //modelへリクエスト
        $item->change_stock_model($request);

        return redirect('/ec/tool')->with('success_message', '在庫数を変更しました');
    }

    //ユーザー管理ページ
    public function user_management(){
        //ログイン情報取得
        $user_id = session('user_id');
        $user_name = session('user_name');
        $adm_flag = session('adm_flag');

        //ログイン済か判断
        if(empty($user_id) === TRUE){
            return redirect('/ec/login')->with('error_message', '不正なアクセスです。');
            exit;
        //管理者権限(1)があるか判断
        }else if($adm_flag !== "1"){
            return redirect('/ec/store');
        }

        //ユーザー一覧取得
        $user = new users();
        $users = $user->all_user();

        return view('user_management',
        ['users' => $users],
        ['user_name' => $user_name],);
    }

    //管理者権限変更
    public function change_adm_flag(request $request){

        //ユーザー一覧取得
        $user = new users();
        list($user_id, $adm_flag) = $user->change_adm_flag($request);

        $login_user_id = session('user_id');

        //ログインユーザーの管理者権限をなしにした場合
        if($login_user_id == $user_id && $adm_flag == 0){
            return redirect('/ec/logout');
            exit;
        }

        return redirect('/ec/tool/admin')->with('success_message', '管理者権限を変更しました');
    }

    //ユーザー削除
    public function delete_user(request $request){

        //ユーザー一覧取得
        $user = new users();
        $user_id = $user->delete_user($request);

        $login_user_id = session('user_id');
        
        //ログインユーザーを削除した場合
        if($login_user_id == $user_id){
            return redirect('/ec/logout');
            exit;
        }
        return redirect('/ec/tool/admin')->with('success_message', 'ユーザーを削除しました');
    }
    
}
