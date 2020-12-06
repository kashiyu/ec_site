<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\item;

class item extends Model{
    //use HasFactory;
    public function items(){

        //アイテム一覧select文
        $item = DB::select("SELECT item.id, img, name, price, stock, status 
        FROM item JOIN stock
        ON Item.id = stock.item_id");

        return $item;
    }

    public function add_item_model($request){
        $errors = [];
        //requestから値を取得
        $name = $request->name;
        $price = $request->price;
        $stock = $request->stock;
        $img = $request->img;
        $status = $request->status;
        $img_dir = \Config::get('fpath.img_dir');
        $new_img_filename = '';   // アップロードした新しい画像ファイル名

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
                    $errors[] = 'ファイルアップロードに失敗しました';
                }
            } else {
                $errors[] = 'ファイルアップロードに失敗しました。再度お試しください。';
            }
        } else {
            $errors[] = 'ファイル形式が異なります。画像ファイルはJPEG又はPNGのみ利用可能です。';
        }

        //エラー確認
        if(empty($errors) === true){
            //トランザクション
            DB::beginTransaction();
            try {
                //itemテーブルをインサート
                DB::insert("INSERT INTO item (name, price,img,status)value('$name',$price,'$new_img_filename','$status')");
                //insertのidを取得
                $id = DB::getPdo()->lastInsertId();
                //stockテーブルをインサート「
                DB::insert("INSERT INTO stock(item_id, stock)value($id,$stock)");
                DB::commit();
            }catch (\Exception $e) {
                DB::rollback();
            }
        }
        return $errors; 
    }

    public function delete_item_model(Request $request){

        //requestから値を取得
        $drink_id = $request->drink_id;
        //トランザクション
        DB::beginTransaction();
        try {
            //stockテーブルをデリート
            DB::delete("DELETE FROM stock wherem WHERE item_id = $drink_id ");

            //itemテーブルをデリート
            DB::delete("DELETE FROM item WHERE id = $drink_id ");

            DB::commit();
        }catch (\Exception $e) {
            DB::rollback();
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
}
