<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class cart extends Model{
    use HasFactory;
    public function get_all_cart($user_id){

        //カートの中身を取得
        $carts = DB::select(
            "SELECT item.id, img, name, price, amount FROM item JOIN cart ON item.id = cart.item_id WHERE user_id = $user_id");

        return $carts;
    }

    //商品をカートへ入れる
    public function add_item_cart($user_id, $item_id){

        //同商品がすでにカート内に入っていか確認
        $cart_in_item = DB::select("SELECT id FROM cart WHERE user_id = $user_id AND item_id = $item_id");


        if(empty($cart_in_item)){
            //カート内に同商品が入っていなかった場合
            //新規でカートに追加
            DB::insert("INSERT INTO cart(user_id,item_id,amount)values($user_id,$item_id,1)");
        }else{
            //カート内に同商品がすでにカートに入っていた場合
            //カート内の個数を+1
            DB::update("UPDATE cart SET amount = amount + 1 WHERE user_id= $user_id AND item_id = $item_id");
        }
        
        return;
    }

    //カートから商品を削除
    public function delete_item_cart($user_id, $item_id){

        DB::delete("DELETE FROM cart WHERE user_id = $user_id AND item_id = $item_id");
        return;
    }

    //カートから商品を削除
    public function change_amount_item_cart($user_id, $item_id, $amount){

        DB::update("UPDATE cart SET amount = $amount WHERE user_id = $user_id AND item_id = $item_id");
        return;
    }

    //商品の購入
    public function buy_item_cart($user_id, $item_id, $amount){

        DB::update("UPDATE cart SET amount = $amount WHERE user_id = $user_id AND item_id = $item_id");
        return;
    }

    //商品購入時、ユーザーのカートの中身を取得
    public function get_buy_cart($user_id){

        $carts = DB::select("SELECT item.id, img, name, price, stock, status, amount FROM cart JOIN item ON cart.item_id = item.id JOIN stock ON cart.item_id = stock.item_id WHERE user_id = $user_id");
        
        return $carts;
    }

    //商品購入時、ユーザーのカートの中身を全削除
    //商品購入分在庫数を減らす
    public function result_cart($user_id, $carts){

        //トランザクション
        DB::beginTransaction();
        try {

            //在庫数を購入数分減らす
            foreach($carts as $value){
                $item_id = $value->id;
                $amount = $value->amount;
                DB::update("UPDATE stock SET stock = stock - $amount WHERE item_id = $item_id");
            }

            //ユーザーのカートの中身を削除
            DB::delete("DELETE FROM cart WHERE user_id = $user_id");
            DB::commit();
            
        }catch (\Exception $e) {
            DB::rollback();
        }
        return;
    }

}
