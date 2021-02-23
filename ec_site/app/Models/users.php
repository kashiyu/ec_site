<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class users extends Model{
    //use HasFactory;
    public function login_user($request){

        //requestから値を取得
        $user_name = $request->user_name;
        $password = $request->password;
        $login_user = "";

        //ハッシュ化されたパスワードを取得
        $user_password = DB::select("SELECT password FROM user WHERE user_name='$user_name'");        
        $hash_password = $user_password[0]->password;

        if (Hash::check($password, $hash_password)) {
            //ユーザー名、パスワードが正しければ取得
            $login_user = DB::select("SELECT id,user_name,adm_flag FROM user WHERE user_name='$user_name' AND password='$hash_password'");
            
        }

        return $login_user;
    }

    //登録時、同ユーザー名がいないか確認
    public function registered_user($request){
        //requestから値を取得
        $user_name = $request->user_name;

        //新規登録するユーザー名がすでに登録されているか確認
        $registered_user = DB::select("SELECT id FROM user WHERE user_name='$user_name'");

        return $registered_user;
    }

    //登録処理
    public function register($request){
        //requestから値を取得
        $user_name = $request->user_name;
        //$password = $request->password;
        $password = Hash::make($request->password);

        //ユーザー登録
        DB::insert("INSERT INTO user(user_name, password, adm_flag)value('$user_name','$password','0')");
    }

    //ユーザー管理ページ全ユーザー取得
    public function all_user(){

        //全ユーザー取得
        $users = DB::select("SELECT id,user_name,adm_flag,create_at FROM user");

        return $users;
    }

    //管理者権限変更
    public function change_adm_flag($request){
        //requestから値を取得
        $user_id = $request->user_id;
        $adm_flag = $request->adm_flag;

        //管理者権限変更
        DB::update("UPDATE user SET adm_flag = '$adm_flag' WHERE id = $user_id");
        
        return [$user_id, $adm_flag];
    }

    //ユーザー削除
    public function delete_user($request){
        //requestから値を取得
        $user_id = $request->user_id;

        //ユーザー削除
        DB::delete("DELETE FROM user WHERE id = $user_id");

        return $user_id;
    }
    
}
