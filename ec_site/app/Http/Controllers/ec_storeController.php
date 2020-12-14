<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\item_store;
use App\Models\cart;
use Illuminate\Support\Facades\Log;

class ec_storeController extends Controller{
    //ECトップページ
    public function index(){ 
        //ログイン情報取得
        $user_id = session('user_id');
        $user_name = session('user_name');
        $adm_flag = session('adm_flag');
        

        //ログイン済か判断
        if(empty($user_id) === TRUE){
            return redirect('/ec/login')->with('error_message', '不正なアクセスです。');
            exit;
        }

        //モデルへリクエスト
        $item = new item_store();
        $items = $item->items();


        return view('ec_store',[
            'user_name' => $user_name,
            'items'      => $items,
            'adm_flag'   => $adm_flag,
        ]);
    }
    //カートページへ遷移
    public function cart_page(){ 

        //ログイン情報取得
        $user_id = session('user_id');
        $user_name = session('user_name');
        $adm_flag = session('adm_flag');

        //購入処理の際のエラーメッセージ(購入する商品が非公開or在庫が足らない)
        $error_array = session('error_array');
        session()->forget('error_array');

        //ログイン済か判断
        if(empty($user_id) === TRUE){
            return redirect('/ec/login')->with('error_message', '不正なアクセスです。');
            exit;
        }

        //ユーザーのカートの中身を取得
        $cart = new cart();
        $carts = $cart->get_all_cart($user_id);

        //合計金額算出
        $array_cart = json_decode(json_encode($carts), true);
        $total_fee = 0;
         foreach($array_cart as $value){
            $tmp = $value['price'] * $value['amount'];
            $total_fee = $total_fee + $tmp;
        }

        return view('ec_cart',[
            'user_name' => $user_name,
            'carts'     => $carts,
            'total_fee' => $total_fee,
            'adm_flag'  => $adm_flag,
            'error_array'   => $error_array]
        );
    }
    //カートへ商品を追加
    public function add_cart(request $request){

        $user_id = session('user_id');
        $item_id = $request->id;

        //商品をカートへ入れる
        $cart = new cart();
        $cart->add_item_cart($user_id, $item_id);

        return redirect('/ec/store')->with('success_message', 'カートに追加しました。');
    }

    //カートから商品を削除
    public function delete_cart(request $request){

        $user_id = session('user_id');
        $item_id = $request->item_id;

        //商品をカートへ入れる
        $cart = new cart();
        $cart->delete_item_cart($user_id, $item_id);

        return redirect('/ec/store/cart')->with('success_message', '商品を削除しました。');
    }

    //カートから商品を削除
    public function change_amount_cart(request $request){

        $user_id = session('user_id');
        $item_id = $request->item_id;
        $amount = $request->amount;

        //商品をカートへ入れる
        $cart = new cart();
        $cart->change_amount_item_cart($user_id, $item_id, $amount);

        return redirect('/ec/store/cart')->with('success_message', '数量を更新しました。');
    }
    
    //商品を購入
    public function buy_item(){

        //ログイン情報取得
        $user_id = session('user_id');
        $user_name = session('user_name');
        $adm_flag = session('adm_flag');

        //商品をカートへ入れる
        $cart = new cart();
        $carts = $cart->get_buy_cart($user_id);

        //商品がカートに入っているか確認
        if(empty($carts)){
            return redirect('/ec/store/cart')->with('error_message', 'カートが空です。');
        }


        $errors_array = [];
        foreach($carts as $value){
            //カートの中身の商品が非公開になっていないか確認
            $public = '1';
            if($value->status !== $public){
                $errors_array[] = $value->name.'が非公開です';
            }

            //購入する数量が在庫数内であるか確認
            if($value->amount > $value->stock){ 
               $errors_array[] = $value->name.'の在庫が足りません';
            }
        }

        //購入する商品に不備（非公開or在庫不足）
        if(!empty($errors_array)){
            session(['error_array'=> $errors_array]);
            return redirect('/ec/store/cart');
        }


        //ユーザーのカートの中身を削除 
        //新たな在庫数の反映
        $cart->result_cart($user_id, $carts);

        //合計金額算出
        $array_cart = json_decode(json_encode($carts), true);
        $total_fee = 0;
            foreach($array_cart as $value){
            $tmp = $value['price'] * $value['amount'];
            $total_fee = $total_fee + $tmp;
        }

        return view('ec_result',[
            'user_name' => $user_name,
            'carts' => $carts,
            'adm_flag'   => $adm_flag,
            'total_fee'   => $total_fee
        ]);
    }
    
}

