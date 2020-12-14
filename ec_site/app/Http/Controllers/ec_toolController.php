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
        if(empty($user_id)){
            return redirect('/ec/login')->with('error_message', '不正なアクセスです。');
            exit;
        }

        
        //管理者権限(1)があるか判断
        $admin = '1';
        if($adm_flag !== $admin){
            return redirect('/ec/store');
            exit;
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

        $errors = [];
        $img = $request->img;

        //ファイル関係の変数初期化 
        $img_dir = public_path('img/');
        //$img_dir = \Config::get('fpath.img_dir');
        $new_img_filename = '';   

        // 画像の拡張子を取得
        $extension = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
        // 指定の拡張子であるかどうかチェック
        if ($extension === 'jpg' || $extension === 'jpeg' || $extension === 'png') {
            // 保存する新しいファイル名の生成（ユニークな値を設定する）
            $new_img_filename = sha1(uniqid(mt_rand(), true)). '.' . $extension; 

            // 同名ファイルが存在するかどうかチェック
            if (is_file($img_dir . $new_img_filename) !== TRUE) {
                // アップロードされたファイルを指定ディレクトリに移動して保存
                if (move_uploaded_file($_FILES['img']['tmp_name'], $img_dir . $new_img_filename) !== TRUE) {
                    return redirect('/ec/tool')->with('error_message', 'ファイルアップロードに失敗しました');
                    exit;
                }
            } else {
                return redirect('/ec/tool')->with('error_message', 'ファイルアップロードに失敗しました。再度お試しください。');
                exit;
            }
        } else {
            return redirect('/ec/tool')->with('error_message', 'ファイル形式が異なります。画像ファイルはJPEG又はPNGのみ利用可能です。');
            exit;
        }
        //モデルへリクエスト
        $item = new item();
        $errors = $item->add_item_model($request,$new_img_filename);

        return redirect('/ec/tool')->with('success_message', '追加しました');
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
        }
        //管理者権限(1)があるか判断
        if($adm_flag !== "1"){
            return redirect('/ec/store');
            exit;
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
