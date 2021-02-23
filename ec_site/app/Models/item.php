<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\item;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class item extends Model{
    //use HasFactory;
    public function items(){

        //アイテム一覧取得
        $item = DB::table('item')
            ->leftJoin('stock', 'item.id', '=', 'stock.item_id')
            ->get();

        return $item;
    }

    public function add_item_model($request,$new_img_filename){
        //requestから値を取得
        $name = $request->name;
        $price = $request->price;
        $stock = $request->stock;
        $status = $request->status;

        //トランザクション
        DB::beginTransaction();
        try {
            //itemテーブルをインサート
            DB::insert("INSERT INTO item (name, price,img,status)value('$name',$price,'$new_img_filename','$status')");
            //insertのidを取得
            $id = DB::getPdo()->lastInsertId();
            //stockテーブルをインサート
            DB::insert("INSERT INTO stock(item_id, stock)value($id,$stock)");
            DB::commit();
        }catch (\Exception $e) {
            DB::rollback();
        }
    
        return; 
    }

    public function delete_item_model(Request $request){

        //requestから値を取得
        $drink_id = $request->drink_id;

        //削除する画像ファイル名取得
        $img = DB::select("SELECT img FROM item WHERE id = $drink_id");
        $img = $img[0]->img;
        //画像ファイル削除
        File::delete('../public/img/' . $img);

        //トランザクション
        DB::beginTransaction();
        try {
            //stockテーブルをデリート
            DB::delete("DELETE FROM stock WHERE item_id = $drink_id ");

            //itemテーブルをデリート
            DB::delete("DELETE FROM item WHERE id = $drink_id ");

            DB::commit();
        }catch (\Exception $e) {
            DB::rollback();
            return redirect('/ec/tool')->with('error_message', '削除失敗');
            exit;
        }
    
    }

    public function change_status_model($request){

        //requestから値を取得
        $status = $request->status;
        $item_id = $request->item_id;
        //ステータス変更アップデート文
        DB::update("update item set status = '$status' where id = $item_id");
    }

    public function change_stock_model($request){
        //requestから値を取得
        $stock   = $request->stock;
        $item_id = $request->item_id;
        //在庫数変更アップデート文
        DB::update("update stock set stock = '$stock' where item_id = $item_id");
    }


    //ECトップページ用全アイテム取得
    public function store_items(){

        //アイテム一覧select文
        $items = DB::select("SELECT item.id, img, name, price, stock 
        FROM item JOIN stock
        ON Item.id = stock.item_id
        WHERE status = '1'");

        return $items;
    }
}
